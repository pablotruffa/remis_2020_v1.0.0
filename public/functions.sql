----------------------------- CLIENT ----------------------------------

DROP FUNCTION IF EXISTS getClientFullNameByReservationId;
DELIMITER $$

CREATE FUNCTION getClientFullNameByReservationId(
	re_id int
) 
RETURNS VARCHAR(500)
DETERMINISTIC
BEGIN
    DECLARE response VARCHAR(500);
		SET response = (SELECT CONCAT_WS(" ",first_name,last_name)
	FROM clients
  LEFT JOIN reservation_has_client ON reservation_has_client.client_id = clients.id
	WHERE reservation_has_client.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;

DROP FUNCTION IF EXISTS getClientIdentificationByReservationId;
DELIMITER $$

CREATE FUNCTION getClientIdentificationByReservationId(
	re_id int
) 
RETURNS BIGINT
DETERMINISTIC
BEGIN
    DECLARE response BIGINT;
		SET response = (SELECT identification_card_number
									 FROM clients
  LEFT JOIN reservation_has_client ON reservation_has_client.client_id = clients.id
	WHERE reservation_has_client.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;

DROP FUNCTION IF EXISTS getClientDateOfBirthByReservationId;
DELIMITER $$

CREATE FUNCTION getClientDateOfBirthByReservationId(
	re_id int
) 
RETURNS DATE
DETERMINISTIC
BEGIN
    DECLARE response DATE;
		SET response = (SELECT date_of_birth
	FROM clients
  LEFT JOIN reservation_has_client ON reservation_has_client.client_id = clients.id
	WHERE reservation_has_client.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;

------------------------------------- DRIVER ------------------------------------
DROP FUNCTION IF EXISTS getDriverFullNameByReservationId;
DELIMITER $$

CREATE FUNCTION getDriverFullNameByReservationId(
	re_id int
) 
RETURNS VARCHAR(300)
DETERMINISTIC
BEGIN
    DECLARE response VARCHAR(300);
		SET response = (SELECT CONCAT_WS(" ",first_name,last_name) AS full_name
	FROM drivers
  LEFT JOIN reservation_has_driver ON reservation_has_driver.driver_id = drivers.id
	WHERE reservation_has_driver.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;

DROP FUNCTION IF EXISTS getDriverIdentificationByReservationId;
DELIMITER $$

CREATE FUNCTION getDriverIdentificationByReservationId(
	re_id int
) 
RETURNS BIGINT
DETERMINISTIC
BEGIN
    DECLARE response BIGINT;
		SET response = (SELECT identification_card_number
	FROM drivers
  LEFT JOIN reservation_has_driver ON reservation_has_driver.driver_id = drivers.id
	WHERE reservation_has_driver.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;

DROP FUNCTION IF EXISTS getDriverCarLicenseByReservationId;
DELIMITER $$

CREATE FUNCTION getDriverCarLicenseByReservationId(
	re_id int
) 
RETURNS VARCHAR(100)
DETERMINISTIC
BEGIN
    DECLARE response VARCHAR(100);
		SET response = (SELECT car_license
	FROM drivers
  LEFT JOIN reservation_has_driver ON reservation_has_driver.driver_id = drivers.id
	WHERE reservation_has_driver.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;

DROP FUNCTION IF EXISTS getDriverDateOfBirthByReservationId;
DELIMITER $$

CREATE FUNCTION getDriverDateOfBirthByReservationId(
	re_id int
) 
RETURNS DATE
DETERMINISTIC
BEGIN
    DECLARE response DATE;
		SET response = (SELECT date_of_birth
	FROM drivers
  LEFT JOIN reservation_has_driver ON reservation_has_driver.driver_id = drivers.id
	WHERE reservation_has_driver.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;


------------------------------------- VEHICLE ------------------------------------

DROP FUNCTION IF EXISTS getVehiclePatentByReservationId;
DELIMITER $$

CREATE FUNCTION getVehiclePatentByReservationId(
	re_id int
) 
RETURNS VARCHAR(100)
DETERMINISTIC
BEGIN
    DECLARE response VARCHAR(100);
		SET response = (SELECT vehicles.patent
	FROM vehicles
	LEFT JOIN drivers
	ON drivers.assigned_vehicle = vehicles.id
	LEFT JOIN reservation_has_driver
	ON reservation_has_driver.driver_id = drivers.id
	WHERE reservation_has_driver.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;

DROP FUNCTION IF EXISTS getVehicleModelByReservationId;
DELIMITER $$

CREATE FUNCTION getVehicleModelByReservationId(
	re_id int
) 
RETURNS VARCHAR(300)
DETERMINISTIC
BEGIN
    DECLARE response VARCHAR(300);
		SET response = (SELECT vehicles.model
	FROM vehicles
	LEFT JOIN drivers
	ON drivers.assigned_vehicle = vehicles.id
	LEFT JOIN reservation_has_driver
	ON reservation_has_driver.driver_id = drivers.id
	WHERE reservation_has_driver.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;

DROP FUNCTION IF EXISTS getVehicleYearByReservationId;
DELIMITER $$

CREATE FUNCTION getVehicleYearByReservationId(
	re_id int
) 
RETURNS YEAR
DETERMINISTIC
BEGIN
    DECLARE response YEAR;
		SET response = (SELECT vehicles.year
	FROM vehicles
	LEFT JOIN drivers
	ON drivers.assigned_vehicle = vehicles.id
	LEFT JOIN reservation_has_driver
	ON reservation_has_driver.driver_id = drivers.id
	WHERE reservation_has_driver.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;

DROP FUNCTION IF EXISTS getVehicleBrandByReservationId;
DELIMITER $$

CREATE FUNCTION getVehicleBrandByReservationId(
	re_id int
) 
RETURNS VARCHAR(100)
DETERMINISTIC
BEGIN
    DECLARE response VARCHAR(100);
		SET response = (SELECT brand FROM car_brands
	LEFT JOIN vehicles
	ON vehicles.id_brand = car_brands.id
	LEFT JOIN drivers
	ON drivers.assigned_vehicle = vehicles.id
	LEFT JOIN reservation_has_driver
	ON reservation_has_driver.driver_id = drivers.id
	WHERE reservation_has_driver.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;

DROP FUNCTION IF EXISTS getVehicleColorByReservationId;
DELIMITER $$

CREATE FUNCTION getVehicleColorByReservationId(
	re_id int
) 
RETURNS VARCHAR(100)
DETERMINISTIC
BEGIN
    DECLARE response VARCHAR(100);
		SET response = (SELECT color FROM car_colors
	LEFT JOIN vehicles
	ON vehicles.id_color = car_colors.id
	LEFT JOIN drivers
	ON drivers.assigned_vehicle = vehicles.id
	LEFT JOIN reservation_has_driver
	ON reservation_has_driver.driver_id = drivers.id
	WHERE reservation_has_driver.reservation_id = re_id LIMIT 1);
    
	RETURN (response);
END$$
DELIMITER ;

----------------------------------------- TRIGGER -------------------------------------
DROP trigger if exists after_reservations_update;
DELIMITER $$

CREATE TRIGGER after_reservations_update
AFTER UPDATE
ON reservations FOR EACH ROW
BEGIN
    IF new.reservation_status = 5 THEN
        INSERT INTO reservation_logs(
						confirmation_number,
						client_full_name,
						client_identification_card_number,
						client_date_of_birth,
						driver_full_name,
						driver_identification_card_number,
						driver_car_license,
						driver_date_of_birth,
						car_patent,
						car_model,
						car_year,
						car_brand,
						car_color)
        VALUES(
						 old.confirmation_number,
						(SELECT getClientFullNameByReservationId(old.id)),
						(SELECT getClientIdentificationByReservationId(old.id)),
						(SELECT getClientDateOfBirthByReservationId(old.id)),
						(SELECT getDriverFullNameByReservationId(old.id)),
						(SELECT getDriverIdentificationByReservationId(old.id)),
						(SELECT getDriverCarLicenseByReservationId(old.id)),
						(SELECT getDriverDateOfBirthByReservationId(old.id)),
						(SELECT getVehiclePatentByReservationId(old.id)),
						(SELECT getVehicleModelByReservationId(old.id)),
						(SELECT getVehicleYearByReservationId(old.id)),
						(SELECT getVehicleBrandByReservationId(old.id)),
						(SELECT getVehicleColorByReservationId(old.id))
				);
    END IF;
END$$

DELIMITER ;
