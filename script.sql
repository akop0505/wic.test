create table places
(
    id                 int auto_increment
        primary key,
    place_name         varchar(100) null,
    state              varchar(100) null,
    state_abbreviation varchar(10)  null,
    longitude          double       null,
    latitude           double       null,
    zip_code           int          not null,
    country_code       varchar(10)  null
);


