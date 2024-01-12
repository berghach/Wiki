CREATE DATABASE brief11;
--@block
CREATE TABLE user(
    id INT AUTO_INCREMENT,
    fullname varchar(30),
    username varchar(15) UNIQUE,
    e_mail varchar(30) UNIQUE,
    psw varchar(12),
    user_role ENUM('admin','author') DEFAULT 'author',
    CONSTRAINT pk_user_id  PRIMARY KEY(id)
);
--@block
INSERT INTO user (fullname, username, e_mail, psw, user_role)
value ('Admin', 'admin1', 'admin1@mail.com', 'admin1234', 'admin');
--@block
CREATE TABLE category(
    id INT AUTO_INCREMENT,
    cat_name VARCHAR(20),
    descreption VARCHAR(1000),
    creation_date datetime DEFAULT CURRENT_TIMESTAMP,
    edit_date datetime DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_category_id PRIMARY KEY(id)
);
--@block
CREATE TABLE wiki(
    id INT AUTO_INCREMENT,
    title VARCHAR(50),
    content LONGTEXT,
    archived boolean DEFAULT 0,
    author_id INT,
    creation_date datetime DEFAULT CURRENT_TIMESTAMP,
    edit_date datetime DEFAULT CURRENT_TIMESTAMP,
    wiki_category INT,
    CONSTRAINT pk_wiki_id PRIMARY KEY(id),
    CONSTRAINT fk_wiki_author FOREIGN KEY (author_id) REFERENCES user(id),
    CONSTRAINT fk_wiki_category FOREIGN KEY (wiki_category) REFERENCES category(id) ON DELETE CASCADE
);
--@block
CREATE TABLE tag(
    id INT AUTO_INCREMENT,
    name_tag VARCHAR(30),
    descreption VARCHAR(1000),
    creation_date datetime DEFAULT CURRENT_TIMESTAMP,
    edit_date datetime DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_tag_id PRIMARY KEY(id)
);
--@block
CREATE TABLE wiki_tag(
    wiki_id INT,
    tag_id INT,
    PRIMARY KEY (wiki_id, tag_id),
    CONSTRAINT fk_wiki FOREIGN KEY (wiki_id) REFERENCES wiki(id),
    CONSTRAINT fk_tag FOREIGN KEY (tag_id) REFERENCES tag(id)
);
--@block
-- Insert authors
INSERT INTO user (fullname, username, e_mail, psw) VALUES
('Author1', 'author1', 'author1@mail.com', 'author123'),
('Author2', 'author2', 'author2@mail.com', 'author456'),
('Author3', 'author3', 'author3@mail.com', 'author789'),
('Author4', 'author4', 'author4@mail.com', 'author000');
--@block

-- Insert categories
INSERT INTO category (cat_name, descreption) VALUES
(1, 'Description for Category1'),
(2, 'Description for Category2'),
(3, 'Description for Category3');
--@block

-- Insert tags
INSERT INTO tag (name_tag, descreption) VALUES
(1, 'Description for Tag1'),
(2, 'Description for Tag2'),
(3, 'Description for Tag3'),
(4, 'Description for Tag4'),
(5, 'Description for Tag5'),
(6, 'Description for Tag6');
--@block

-- Insert  wikis with content (max 100 words), associating authors, tags, and categories
INSERT INTO wiki (title, content, author_id, wiki_category) VALUES
('Wiki1 Title', 'Content for Wiki1. This is a sample wiki content.', 1, 1),
('Wiki2 Title', 'Content for Wiki2. This is another sample wiki content.', 1, 2),
('Wiki3 Title', 'Content for Wiki3. Yet another sample wiki content.', 2, 1),
('Wiki4 Title', 'Content for Wiki4. A different sample wiki content.', 2, 3),
('Wiki5 Title', 'Content for Wiki5. Some more sample wiki content.', 1, 2),
('Wiki6 Title', 'Content for Wiki6. This is a sample wiki content.', 4, 1),
('Wiki7 Title', 'Content for Wiki7. This is another sample wiki content.', 4, 2),
('Wiki8 Title', 'Content for Wiki8. Yet another sample wiki content.', 5, 1),
('Wiki9 Title', 'Content for Wiki9. A different sample wiki content.', 5, 3),
('Wiki10 Title', 'Content for Wiki10. Some more sample wiki content.', 4, 2);
--@block

-- Insert tags for wikis
INSERT INTO wiki_tag (wiki_id, tag_id) VALUES
(1, 1), (1, 2), (2, 3), (3, 4), (3, 5), (4, 2), (5, 6),
(6, 1), (6, 2), (7, 3), (8, 4), (8, 5), (9, 2), (10, 6);

--@block

--get wikis by category
SELECT wiki.* FROM wiki LEFT JOIN category ON wiki.wiki_category=category.id WHERE category.id='?';

--get wikis by tag
SELECT wiki.* FROM wiki LEFT JOIN (tag LEFT JOIN wiki_tag on tag.id=wiki_tag.tag_id) on wiki.id=wiki_tag.wiki_id WHERE tag.id='?';

--get the wiki tags
SELECT tag.* FROM tag LEFT JOIN (wiki LEFT JOIN wiki_tag on wiki.id=wiki_tag.wiki_id) on tag.id=wiki_tag.tag_id WHERE wiki.id='?';
