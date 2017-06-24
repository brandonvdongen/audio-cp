create table permissions
(
	id_permissions int not null auto_increment
		primary key,
	see_all tinyint(1) default '0' not null,
	edit_all tinyint(1) default '0' not null,
	remove_all int default '0' not null,
	id_user int not null
)
;

create table songs
(
	id_owner int not null,
	public tinyint(1) default '1' not null,
	song_name varchar(255) not null,
	song_author varchar(255) not null,
	song_data text not null,
	id_song int not null auto_increment
		primary key
)
;

create table users
(
	username varchar(100) not null,
	nickname varchar(100) not null,
	password varchar(100) not null,
	uuid varchar(255) not null,
	id_user int not null auto_increment,
	link varchar(255) default 'unlinked' null,
	constraint username
	unique (username)
)
;

create index id_users
	on users (id_user)
;

