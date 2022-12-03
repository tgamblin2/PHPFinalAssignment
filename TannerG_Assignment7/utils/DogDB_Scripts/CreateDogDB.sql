create database if not exists dogdb;

use dogdb;

create table AvailableDogs
(
    dogID int not null,
    dogName varchar(15) not null,
    dogAge int not null,
    dogBreed varchar(40) not null,
    trained boolean not null,
    primary key (dogID)
);

insert into AvailableDogs values(1, 'Bonnie', 1, 'Labrador Retriever', false);
insert into AvailableDogs values(2, 'Travis', 5, 'Hungarian Wire-Haired Pointer', true);
insert into AvailableDogs values(3, 'Daisy', 3, 'Cocker Spaniel', false);
insert into AvailableDogs values(4, 'Phillip', 11, 'Norman Artesien Basset', true);
insert into AvailableDogs values(5, 'Jackal', 8, 'Brazilian Terrier', true);
insert into AvailableDogs values(6, 'Dog', 4, 'Portuguese Water Dog', true);
insert into AvailableDogs values(7, 'Cooper', 7, 'Portuguese Sheepdog', true);
insert into AvailableDogs values(8, 'Alexander IV', 2, 'Continential Toy Spaniel', false);
insert into AvailableDogs values(9, 'Buddy', 2, 'Picardy Sheepdog', false);
insert into AvailableDogs values(10, 'Felix', 3, 'Suspiciously Cat-Like Dog', true);
insert into AvailableDogs values(11, 'Bella', 8, 'Dogue de Bordeaux', true);
insert into AvailableDogs values(12, 'Sampson', 5, 'Duck Tolling Retriever', true);
insert into AvailableDogs values(13, 'Dog', 2, 'Labrador Retriever', false);
insert into AvailableDogs values(14, 'Ollie', 4, 'Golden Retriever', true);
insert into AvailableDogs values(15, 'Jacob', 2, 'Fox Terrier', false);
insert into AvailableDogs values(16, 'Kitty', 9, 'Ariegeois', true);
insert into AvailableDogs values(17, 'Tiger', 1, 'French Tricolour Hound', false);
insert into AvailableDogs values(18, 'John', 1, 'Frisian Water Dog', false);
insert into AvailableDogs values(19, 'Spencer', 1, 'Shar Pei', false);
insert into AvailableDogs values(20, 'Rigby', 7, 'Boston Terrier', true);

