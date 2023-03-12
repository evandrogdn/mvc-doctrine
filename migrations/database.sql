create table if not exists pessoa (
	id serial,
	nome varchar not null,
	cpf varchar not null,
	constraint pk_pessoa primary key (id)
);

create type tipo_contato as enum ('telefone', 'email');

create table if not exists contato (
	id serial,
	tipo tipo_contato not null,
	descricao varchar not null,
	id_pessoa int4 not null,
	constraint pk_contato primary key (id),
	constraint fk_contato_pessoa foreign key (id_pessoa) references pessoa (id)
);