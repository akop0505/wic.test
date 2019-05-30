(function () {
    "use strict";
    let search = document.getElementById("search");
    search.addEventListener("click", handleSearch)

    function handleSearch() {
        let cc = countries.value;
        let zc = zipcode.value;
        removeElementsByClass("remove");
        var client = new XMLHttpRequest();
        client.open("GET", `http://wic.test.local/places?cc=${cc}&zc=${zc}`, true);
        client.onreadystatechange = function () {
            if (client.readyState == 4) {
                let response = JSON.parse(client.responseText);
                showResult(response.places);
            };
        };
        client.send();
    }

    function showResult(places){
        if(places.length){
            for(let i = 0; i <= places.length-1; i++){
                let result = document.getElementById('result');
                let rClone = result.cloneNode(true);
                rClone.id = "result" + i;
                rClone.className += " remove";
                appendItem(rClone,places[i]);
                rClone.appendChild(document.createElement("hr"));
                document.getElementById('result-row').appendChild(rClone);
            }
        }
        else {
            let result = document.getElementById('result');
            let rClone = result.cloneNode(true);
            rClone.id = "no_result";
            rClone.className += " remove";
            rClone.innerHTML = "<h6 class='text-center'>No place is found</h6>";
            document.getElementById('result-row').appendChild(rClone);
        }
    }
    
    function appendItem(domElement,obj){
        let keys = Object.keys(obj);
        for(let i = 0; i<= keys.length -1; i++ ) {
            if(keys[i] == "id"){
                continue;
            }
            let item = domElement.firstElementChild.cloneNode(true);
            let children = item.children;
            children[0].innerHTML = keyToName(keys[i]) + " :";
            children[1].innerHTML = obj[keys[i]];
            domElement.appendChild(item);
        }
    }

    function keyToName(key){
        key = key.replace("_"," ");
        return key.charAt(0).toUpperCase() + key.slice(1);
    }

    function removeElementsByClass(className){
        var elements = document.getElementsByClassName(className);
        while(elements.length > 0){
            elements[0].parentNode.removeChild(elements[0]);
        }
    }
})();