CREATE TABLE simbologia(id_simbol int AUTO_INCREMENT primary key not null,nombre varchar(50),signo varchar(3));
insert into simbologia values('estrellaXL','1');
insert into simbologia values('solXL','2');
insert into simbologia values('solM','3');
insert into simbologia values('estrellaM','4');
insert into simbologia values('solS','5');
insert into simbologia values('estrellaS','6');
select * from simbologia


CREATE TABLE encuestas(

id_encuesta int AUTO_INCREMENT primary key not null,
obj1_simbol int references simbologia(id_simbol),
obj1_Xpos float,
obj1_Ypos float,

obj2_simbol int references simbologia(id_simbol),
obj2_Xpos float,
obj2_Ypos float,

pendiente float
)