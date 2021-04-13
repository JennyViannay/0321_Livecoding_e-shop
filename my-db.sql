CREATE TABLE `category`(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  name VARCHAR(100)
);

CREATE TABLE `product`(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  title VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  price INT NOT NULL,
  qty INT NOT NULL,
  category_id INT NOT NULL
);

CREATE TABLE `user`(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  firstname VARCHAR(100) NOT NULL,
  lastname VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  address TEXT NOT NULL,
  password VARCHAR(10) NOT NULL,
  is_admin BOOL NOT NULL
);

CREATE TABLE `order`(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  created_at DATETIME NOT NULL,
  total INT NOT NULL,
  user_id INT NOT NULL
);

CREATE TABLE `order_product`(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  qty INT NOT NULL
);

ALTER TABLE product ADD CONSTRAINT FK_product_category FOREIGN KEY (category_id) REFERENCES category(id);
ALTER TABLE `order` ADD CONSTRAINT FK_order_user FOREIGN KEY (user_id) REFERENCES `user`(id);
ALTER TABLE `order_product` ADD CONSTRAINT FK_order_id FOREIGN KEY (order_id) REFERENCES `order`(id);
ALTER TABLE `order_product` ADD CONSTRAINT FK_product_id FOREIGN KEY (product_id) REFERENCES `product`(id);