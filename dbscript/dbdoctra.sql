create database dbdoctra;
use dbdoctra;

create table tusuario
(
codigoUsuario char(13) not null,
nombre varchar (70) not null,
apellido varchar(40) not null,
correoElectronico varchar(700) not null,
contrasenia text not null,
rol varchar(700) not null,/*Súper usuario,Administrador*/
created_at datetime not null,
updated_at datetime not null, 
primary key(codigoUsuario)
);

create table toficina 
(
codigoOficina char(13) not null,
nombre varchar(700) not null,
created_at datetime not null,
updated_at datetime not null, 
primary key(codigoOficina)
);

create table tdocumento
(
codigoDocumento char(13) not null,
nombre varchar(700) not null,
folio int not null,
tipo varchar(70) not null,
extension varchar(10) not null,
created_at datetime not null,
updated_at datetime not null, 
primary key(codigoDocumento)
);

create table totdevtasignacion
(
codigoOTDEvtAsignacion char(13) not null,
codigoOTDEvtAsignacionPadre char(13) null,
codigoDocumento char(13) null,
codigoOficina char(13) null,
codigoUsuario char(13) not null,
nombreCompletoPersonaPresenta varchar(110) not null,
dniPersonaPresenta char(8) not null,
observacion text not null,
activo boolean not null,
estado varchar(70) not null,
created_at datetime not null,
updated_at datetime not null, 
foreign key(codigoOTDEvtAsignacionPadre) references totdevtasignacion(codigoOTDEvtAsignacion)
on delete cascade on update cascade,
foreign key(codigoDocumento) references tdocumento(codigoDocumento)
on delete cascade on update cascade,
foreign key(codigoOficina) references toficina(codigoOficina)
on delete cascade on update cascade,
foreign key(codigoUsuario) references tusuario(codigoUsuario)
on delete cascade on update cascade,
primary key(codigoOTDEvtAsignacion)
);

create table totdevtarchivo
(
codigoOTDEvtArchivo char(13) not null,
codigoOTDEvtAsignacion char(13) not null,
codigoDocumento char(13) not null,
created_at datetime not null,
updated_at datetime not null, 
foreign key(codigoOTDEvtAsignacion) references totdevtasignacion(codigoOTDEvtAsignacion)
on delete cascade on update cascade,
foreign key(codigoDocumento) references tdocumento(codigoDocumento)
on delete cascade on update cascade,
primary key(codigoOTDEvtArchivo)
);

create table texcepcion
(
codigoExcepcion char(13) not null,
codigoUsuario char(13) null,
controlador varchar(70) not null,
accion varchar(70) not null,
error text not null,
estado varchar(20) not null,/*Pendiente, Atendido*/
created_at datetime not null,
updated_at datetime not null,
foreign key(codigoUsuario) references tusuario(codigoUsuario)
on delete cascade on update cascade,
primary key(codigoExcepcion)
);

insert into tusuario values('5a773f821ff84', 'Kevin Arnold', 'Arias Figueroa', 'kaaf030191@gmail.com', 'eyJpdiI6IlwvOWcyRkl0TCsrekl2OGQxeU5hS0N3PT0iLCJ2YWx1ZSI6IkFRK3VjNkNONUN4dTVUZ0I2WHE3Snc9PSIsIm1hYyI6ImQ5ZTE0ZGVkNzY3MWVmYzdjOGI4NTRkYmM0MjY2YzVmMjYyNTliMDZmMWRiOGM1MDkzZDA0YTBhNGM5NjRhNDUifQ==', 'Súper usuario', now(), now());
insert into toficina values('5a77e6b97955a', 'Mesa de partes', now(), now());