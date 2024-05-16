
CREATE TABLE adminlist (
    adminid INT NOT NULL AUTO_INCREMENT ,
    username VARCHAR(30) NOT NULL ,
    adminpwd VARCHAR(255) NOT NULL,
    PRIMARY KEY (adminid)
);

create table vehicle (
    vehicle_id int not null auto_increment,
    vehicle_type varchar(50) not null,
    vehicle_license_plate varchar(50) not null,
    vehicle_model varchar(50) not null,
    vehicle_color varchar(50) not null,
    odometer_reading int not null,
    fuel_type varchar(50) not null,
    inssurance_info text not null,
    vehicle_location varchar(50) not null,
    vehicle_status varchar(50) not null,

    constraint pk_vehicle_id primary key (vehicle_id)
);

create table vehicle_maintenance (
    maintenance_id int not null auto_increment,
    vehicle_id int not null,
    maintenance_date date not null,
    maintenance_type varchar(50) not null,
    maintenance_description text not null,
    workshop_name varchar(50) not null,
    workshop_phone varchar(50) not null,
    cost float not null,
    next_maintenance_date date not null,
    maintenance_status varchar(30) not null,

    constraint pk_maintenance_id primary key (maintenance_id),
    constraint fk_vehicle_id foreign key (vehicle_id) references vehicle(vehicle_id)
);




CREATE TABLE driver (
    driver_id int NOT NULL AUTO_INCREMENT,
    driver_name varchar(50) NOT NULL,
    driver_birthdate date NOT NULL,
    driver_phone varchar(50) NOT NULL,
    driver_address varchar(255) NOT NULL,
    username varchar(50) NOT NULL,
    pwd varchar(255) NOT NULL,
    employment_date date NOT NULL,
    monthly_salary float NOT NULL,
    driver_history text NOT NULL,
    driver_status varchar(50) NOT NULL,
    driver_license_number varchar(50) NOT NULL,
    PRIMARY KEY (driver_id)
);


create table mission (
    mission_id int not null auto_increment,
    driver_id int not null,
    start_date_time datetime not null,
    end_date_time datetime not null,
    start_location varchar(50) not null,
    end_location varchar(50) not null,
    purpose varchar(255) not null,
    mission_status varchar(50) not null,
    cost float not null,
    vehicle_id int not null,
    constraint pk_mission_id primary key (mission_id),
    constraint fk_driver_id foreign key (driver_id) references driver(driver_id),
    constraint fk_vehicle_id foreign key (vehicle_id) references vehicle(vehicle_id)
);


create table vehicle_expense (
    expense_id int not null auto_increment,
    vehicle_id int not null,
    expense_date date not null,
    expense_type varchar(255) not null,
    expense_cost float not null,

    primary key (expense_id),
    foreign key (vehicle_id) references vehicle(vehicle_id)
);


create table penality_expense (
    penality_id int not null auto_increment,
    driver_id int not null,
    penality_date date not null,
    penality_type varchar(255) not null,
    penality_cost float not null,

    primary key (penality_id),
    foreign key (driver_id) references driver(driver_id)
);

create table admin_report (
    report_id int not null auto_increment,
    report_date date not null,
    report_issue varchar(255) not null,
    report_description text not null,

    primary key (report_id)
);


create table driver_report (
    report_id int not null auto_increment,
    driver_id int not null,
    report_date date not null,
    report_issue varchar(255) not null,
    vehicle_location varchar(255) not null,

    primary key (report_id),
    foreign key (driver_id) references driver(driver_id)
);