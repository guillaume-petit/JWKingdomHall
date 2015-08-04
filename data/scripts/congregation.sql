-- Congregation
insert into congregation (code, name, default_locale) values ('3277','Montreux-F','fr');

-- Settings
insert into congregation_setting (congregation_id, type, code, value)
select id, 'string','date_format_twig','d/m/Y' from congregation where code = '3277';
insert into congregation_setting (congregation_id, type, code, value)
select id, 'string','territory_max_borrow_time','4 months' from congregation where code = '3277';
insert into congregation_setting (congregation_id, type, code, value)
select id, 'string','territory_warning_borrow_time','3 months' from congregation where code = '3277';
insert into congregation_setting (congregation_id, type, code, value)
select id, 'array','excluded_languages','Anglais,Portugais,Arabe,Chinois' from congregation where code = '3277';
