USE alex_webshop;

CREATE TABLE orders (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id int(11) NOT NULL,
  total_price decimal(10,2) NOT NULL,
  order_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status varchar(50) DEFAULT 'pending',
  shipping_address text NOT NULL,
  payment_method varchar(50) NOT NULL,
  tracking_number varchar(100) DEFAULT NULL,
  firstname varchar(50) NOT NULL,
  lastname varchar(50) NOT NULL,
  street varchar(255) NOT NULL,
  housenumber varchar(10) NOT NULL,
  city varchar(100) NOT NULL,
  zipcode varchar(20) NOT NULL,
  country varchar(100) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
