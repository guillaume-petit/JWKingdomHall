ALTER TABLE publisher ADD user_id INT DEFAULT NULL;
ALTER TABLE publisher ADD CONSTRAINT FK_9CE8D546A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id);
CREATE UNIQUE INDEX UNIQ_9CE8D546A76ED395 ON publisher (user_id);
