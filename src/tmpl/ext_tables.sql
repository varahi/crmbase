CREATE TABLE pages (
    hide_breadcrumb int(11) unsigned DEFAULT '0' NOT NULL,
    section_class varchar(255) DEFAULT '' NOT NULL,
    container_class varchar(255) DEFAULT '' NOT NULL,
    phone_home varchar(255) DEFAULT '' NOT NULL,
);

CREATE TABLE tt_content (
    image_class varchar(22) DEFAULT '' NOT NULL,
);
