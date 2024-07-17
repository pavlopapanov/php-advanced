-- Видалення однієї з таблиць
DROP TABLE cars;

-- Модифікація поля таблиці (наприклад, поле типу datetime стало date, або зміна імені поля)
-- Додати/змінити колонку за допомогою команди ALTER TABLE
ALTER TABLE orders MODIFY start INTEGER;
ALTER TABLE orders CHANGE start start_new TEXT;

-- Заповнення кожної таблиці хоча б по 3-5 записів
INSERT INTO cars SET id = 1, park_id = 1, model = 'Mercedes', price = 200000;
INSERT INTO cars SET id = 2, park_id = 2, model = 'Ferrari', price = 400000;
INSERT INTO cars SET id = 3, park_id = 3, model = 'Mustang', price = 250000;

INSERT INTO customers SET id = 1, name = 'Victoria', phone = '(254) 898-2858';
INSERT INTO customers SET id = 2, name = 'John', phone = '(601) 579-6844';
INSERT INTO customers SET id = 3, name = 'Taylor', phone = '(623) 236-9823';

INSERT INTO drivers SET id = 1, car_id = 3, name = 'Alex', phone = '(254) 875-2470';
INSERT INTO drivers SET id = 2, car_id = 1, name = 'Jacob', phone = '(586) 727-9015';
INSERT INTO drivers SET id = 3, car_id = 2, name = 'Leo', phone = '(518) 627-0389';

INSERT INTO orders SET id = 1, driver_id = 1, customer_id = 3, start = '2024-07-11', finish = '2024-07-18', total = '7';
INSERT INTO orders SET id = 2, driver_id = 2, customer_id = 1, start = '2024-07-11', finish = '2024-07-18', total = '7';
INSERT INTO orders SET id = 3, driver_id = 3, customer_id = 2, start = '2024-07-11', finish = '2024-07-18', total = '7';

INSERT INTO parks SET id = 1, address = '716 Turcotte Ways, West Melindaburgh, AR 13325-1913';
INSERT INTO parks SET id = 2, address = 'Apt. 578 671 Witting Knoll, Jacqueshaven, TN 51784-4347';
INSERT INTO parks SET id = 3, address = '62754 Okuneva Corners, Lake Kittyfurt, NV 63839';

-- Модифікації будь-якого запису (наприклад, змінити серійний номер автопарку)
UPDATE parks SET address = '38 S High St Melrose, Massachusetts(MA), 02176' WHERE id = 1;

-- Видалення запису з таблиці
UPDATE parks SET address = NULL WHERE id = 1;

-- Ну і пару різних запитів до бази даних (маю на увазі SELECT)
-- 1-2 приклади Join запиту
SELECT * FROM customers WHERE name = 'Victoria';

SELECT name, phone, start, finish, total FROM customers JOIN orders ON customers.id = orders.customer_id;

