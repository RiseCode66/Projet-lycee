create table eleve(
    idE int primary key auto_increment not null,
    matricule varchar(255),
    nom varchar(255),
    prenom varchar(255),
    dtn date
)engine=innoDB;
create table specialite(
    id int primary key,
    nom varchar(255)
)engine=innoDB;

create table niveau(
    id int primary key auto_increment not null,
    idS int,
    nom varchar(255),
    foreign key (idS) references specialite(id)
)engine=innoDB;
create table situation(
    id int primary key auto_increment not null,
    idE int,
    idN int,
    foreign key (idE) references eleve(idE),
    foreign key (idN) references niveau(id)
)engine=innoDB;
create table matiere(
    id int primary key auto_increment not null,
    nom varchar(255)
)engine=innoDB;
create table Coefficient(
    id int primary key auto_increment not null,
    idN int,
    idM int,
    foreign key (idM) references matiere(id),
    foreign key (idN) references niveau(id)
)engine=innoDB;
create table Evaluation(
    id int primary key auto_increment not null,
    nom varchar(255)
k)engine=innoDB;
create table note(
    id int primary key auto_increment not null,
    idE int not null
    idEx
    idM
)engine=innoDB;
create table type_user(
    id int primary key auto_increment not null,
    nom varchar(255)
)engine=innoDB;
create table periode(
    id int primary key auto_increment not null,
    nom varchar(255),
    dateDebut date,
    dateFin date,
    create_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp()
)engine=innoDB;
create table appreciation(
    id int primary key auto_increment not null,
    valeur varchar(255),
    idp int,
    idm int,
    ide int,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp()
)engine=innoDB;

create table appreciation_cc(
    id int primary key auto_increment not null,
    valeur varchar(255),
    idp int,
    ide int,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp()
)engine=innoDB;

create table annesco(
    id int primary key auto_increment not null,
    nom varchar(255),
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp()
)engine=innoDB;

create table prof(
    id int primary key auto_increment not null,
    nom varchar(255),
    sign varchar(255),
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp()
)engine=innoDB;

create table assignation(
    idp int,
    idn int,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp()
)engine=innoDB;

create table pp(
    id int primary key auto_increment not null,
    idp int,
    idn int,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp()
)engine=innoDB;

create table abs(
    id int primary key auto_increment not null,
    ide int,
    dateDebut date,
    dateFin date,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp()
)engine=innoDB;
create table emploie_du_temps(
    id int primary key auto_increment not null,
    idn int,
    idm int,
    jour int,
    heure int,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp()
)engine=innoDB;

create table classe_exam(
    id int primary key auto_increment not null,
    idm int,
    idc int,
    idex int,
    date_debut int,
    date_fin int,
    nbr_sujets int,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp()
)engine=innoDB;

create table pointage(
    id int primary key auto_increment not null,
    idp int,
    jour date,
    arrive time,
    sortie time,
    created_at timestamp default current_timestamp(),
    updated_at timestamp default current_timestamp()
)engine=innoDB;

create or replace view matiere_coeff as select matiere.*,valeur,idn from matiere
join Coefficient on matiere.id=Coefficient.idM;

create or replace view info_etu as select distinct eleve.id as id,eleve.nom as nom,prenom,dtn,niveau.id as idn,niveau.nom as nomN,coalesce((select sum(jours) from abs where ide=eleve.id),0) as abs from eleve
left join (select * from situation s1 where s1.id=(select max(id) from situation s2 where s2.ide=s1.ide)) situation on eleve.id=situation.idE
left join niveau on situation.idN=niveau.id
Order by situation.updated_at DESC;

create or replace view listnote select ie.id as idE,c.valeur as coeff,m.id as idm,m.nom as nomM,coalesce(n.valeur,0) as note,idex from info_etu ie
join Coefficient c on ie.idn=c.idN
join matiere m on m.id=c.idM
left join note n on n.idM=m.id and n.idE=ie.id;

create or replace view list_exam as select e.id as id ,e.nom as nom,idp,p.nom as nomP from exam e
join periode p on p.id=e.idp;

create view point_examen as select * from note
join idE on eleve.id=note.idE
join id on eleve.id=note.idE
join idE on eleve.id=note.idE

CREATE or replace VIEW listnote AS
select `ie`.`id` AS `idE`,`ie`.`idn` AS `idN`,`ie`.`nomN` AS `nomN`,`c`.`valeur` AS `coeff`,`m`.`id` AS `idm`,`m`.`nom` AS `nomM`,coalesce(`n`.`valeur`,0) AS `note`,`n`.`idex` AS `idex` from (((`grace`.`info_etu` `ie`
join `grace`.`coefficient` `c` on(`ie`.`idn` = `c`.`idn`))
join `grace`.`matiere` `m` on(`m`.`id` = `c`.`idm`))
left join `grace`.`note` `n` on(`n`.`idm` = `m`.`id` and `n`.`idE` = `ie`.`id`));
create or replace view moyenne_class_examen as
select idEx,listnote.idN,sum(coeff*note)/sum(coeff) as moyenne,info_etu.nomN,nom,prenom from listnote
join info_etu on listnote.idE=info_etu.id
group by idEx,listnote.idN order by moyenne;

create or replace view moyenne_class_examen as
select max(nom) as nom,max(prenom) as prenom,idE,idEx,sum(coeff*note)/sum(coeff) as moyenne,listnote.idN as idN from listnote
join info_etu on listnote.idE=info_etu.id
group by idE,idEx,listnote.idN order by moyenne DESC;

create or replace view moyenne_class_examen_matiere as
select max(nom) as nom,max(prenom) as prenom,idE,idEx,sum(note) as moyenne,listnote.idN as idN,idM from listnote
join info_etu on listnote.idE=info_etu.id
group by idE,idEx,listnote.idN,idM order by moyenne DESC;

create or replace view bulletin as
select ide,max(ie.nom) as nom,max(prenom) as prenom, (sum(valeur*coeff))/sum(coeff) as moyenne,s1.idN,idp from (select ide,idN,idp,idM,avg(note) as valeur,coeff from listnote
join exam on listnote.idex=exam.id
group by ide,idM,idN,idp) as s1
join info_etu ie on ie.id=s1.ide
group by ide,s1.idN,idp;

create or replace view bulletinv2 as
select
    s1.ide,
    max(ie.nom) as nom,
    max(ie.prenom) as prenom,
    (sum(s1.valeur * s1.coeff)) / sum(s1.coeff) as moyenne,
    s1.idN,
    s1.idp,
    s1.idM,
    s1.idex
from (
    select
        ide,
        idN,
        idp,
        idM,
        idex,
        avg(note) as valeur,
        coeff
    from listnote
    join exam on listnote.idex = exam.id
    group by ide, idM, idN, idp, coeff
) as s1
join info_etu ie on ie.id = s1.ide
group by s1.ide, s1.idN, s1.idp,s1.idex, s1.idM;

CREATE VIEW ${nameWithSchemaName} AS
select distinct `grace`.`eleve`.`id` AS `id`,`grace`.`eleve`.`nom` AS `nom`,`grace`.`eleve`.`prenom` AS `prenom`,`grace`.`eleve`.`dtn` AS `dtn`,`grace`.`niveau`.`id` AS `idn`,`grace`.`niveau`.`nom` AS `nomN`
from ((`grace`.`eleve` left join `grace`.`situation` on(`grace`.`eleve`.`id` = `grace`.`situation`.`idE`)) left join `grace`.`niveau` on(`grace`.`situation`.`idN` = `grace`.`niveau`.`id`)) order by `grace`.`situation`.`updated_at` desc

