CREATE DATABASE brief11;
--@block
CREATE TABLE user(
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname varchar(30),
    username varchar(15),
    e_mail varchar(30),
    psw varchar(12),
    user_role ENUM('admin','author') DEFAULT 'author'
);
--@block
INSERT INTO user (fullname, username, e_mail, psw, user_role)
value ('Admin', 'admin1', 'admin1@mail.com', 'admin1234', 'admin');
--@block
CREATE TABLE category(
    cat_name VARCHAR(20) PRIMARY KEY,
    descreption VARCHAR(1000),
    creation_date datetime,
    edit_date datetime
);
--@block
CREATE TABLE wiki(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50),
    content LONGTEXT,
    author_id INT,
    creation_date datetime,
    edit_date datetime,
    wiki_category VARCHAR(20),
    FOREIGN KEY (author_id) REFERENCES user(id),
    FOREIGN KEY (wiki_category) REFERENCES category(cat_name)
);
--@block
CREATE trigger
--@block
CREATE TABLE tag(
    name_tag VARCHAR(30) PRIMARY KEY,
    descreption VARCHAR(1000),
    creation_date datetime,
    edit_date datetime
);
--@block
CREATE TABLE wiki_tag(
    wiki_id INT,
    tag_name VARCHAR(30),
    PRIMARY KEY (wiki_id, tag_name),
    FOREIGN KEY (wiki_id) REFERENCES wiki(id),
    FOREIGN KEY (tag_name) REFERENCES tag(name_tag)
);
--@block
-- Insert 2 authors
INSERT INTO user (fullname, username, e_mail, psw, user_role) VALUES
('Author1', 'author1', 'author1@mail.com', 'author123', 'author'),
('Author2', 'author2', 'author2@mail.com', 'author456', 'author');

-- Insert 3 categories
INSERT INTO category (cat_name, descreption, creation_date, edit_date) VALUES
('Category1', 'Description for Category1', NOW(), NOW()),
('Category2', 'Description for Category2', NOW(), NOW()),
('Category3', 'Description for Category3', NOW(), NOW());

-- Insert 6 tags
INSERT INTO tag (name_tag, descreption, creation_date, edit_date) VALUES
('Tag1', 'Description for Tag1', NOW(), NOW()),
('Tag2', 'Description for Tag2', NOW(), NOW()),
('Tag3', 'Description for Tag3', NOW(), NOW()),
('Tag4', 'Description for Tag4', NOW(), NOW()),
('Tag5', 'Description for Tag5', NOW(), NOW()),
('Tag6', 'Description for Tag6', NOW(), NOW());

-- Insert 5 wikis with content (max 100 words), associating authors, tags, and categories
INSERT INTO wiki (title, content, author_id, creation_date, edit_date, wiki_category) VALUES
('Wiki1 Title', 'Content for Wiki1. This is a sample wiki content.', 1, NOW(), NOW(), 'Category1'),
('Wiki2 Title', 'Content for Wiki2. This is another sample wiki content.', 1, NOW(), NOW(), 'Category2'),
('Wiki3 Title', 'Content for Wiki3. Yet another sample wiki content.', 2, NOW(), NOW(), 'Category1'),
('Wiki4 Title', 'Content for Wiki4. A different sample wiki content.', 2, NOW(), NOW(), 'Category3'),
('Wiki5 Title', 'Content for Wiki5. Some more sample wiki content.', 1, NOW(), NOW(), 'Category2');

-- Insert tags for wikis
INSERT INTO wiki_tag (wiki_id, tag_name) VALUES
(1, 'Tag1'), (1, 'Tag2'), (2, 'Tag3'), (3, 'Tag4'), (3, 'Tag5'), (4, 'Tag2'), (5, 'Tag6');


--get wikis by authors
SELECT * FROM wiki LEFT JOIN user ON wiki.author_id=user.id WHERE user.id=?;

--get wikis by category
SELECT * FROM wiki LEFT JOIN category ON wiki.wiki_category=category.cat_name WHERE category.cat_name='?';

--get wikis by tag
SELECT * FROM wiki LEFT JOIN (tag LEFT JOIN wiki_tag on tag.name_tag=wiki_tag.tag_name) on wiki.id=wiki_tag.wiki_id WHERE tag.name_tag='?';