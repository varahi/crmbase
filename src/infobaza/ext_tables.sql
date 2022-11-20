CREATE TABLE tx_infobaza_domain_model_chapter (
	title varchar(255) NOT NULL DEFAULT '',
	bodytext text,
	file int(11) unsigned NOT NULL DEFAULT '0',
	contain int(11) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_infobaza_domain_model_contain (
	chapter int(11) unsigned DEFAULT '0' NOT NULL,
	title varchar(255) NOT NULL DEFAULT '',
	bodytext longtext,
	file int(11) unsigned NOT NULL DEFAULT '0',
	subcontain int(11) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_infobaza_domain_model_subcontain (
	contain int(11) unsigned DEFAULT '0' NOT NULL,
    file int(11) unsigned NOT NULL DEFAULT '0',
	title varchar(255) NOT NULL DEFAULT '',
	bodytext text
);
