create table users
(
	username varchar(100) not null,
	nickname varchar(100) not null,
	password varchar(100) not null,
	id_users int not null auto_increment
		primary key,
	uuid varchar(255) not null,
	constraint username
	unique (username)
);

create table songs
(
	id_songs int not null auto_increment
		primary key,
	id_owner int not null,
	public tinyint(1) default '1' not null,
	song_name varchar(255) not null,
	song_author varchar(255) not null,
	song_data text not null
)
;

create table permissions
(
	id_permissions int not null auto_increment
		primary key,
	id_users int not null,
	see_all tinyint(1) default '0' not null,
	edit_all tinyint(1) default '0' not null,
	remove_all int default '0' not null
)
;

