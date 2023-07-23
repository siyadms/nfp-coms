use nfpcodb;


create table User(
    user_id varchar(10) primary key,
    first_name varchar(30) not null,
    last_name varchar(30) not null,
    email varchar(50) not null unique,
    phone varchar(10) not null,
    gender varchar(10) not null,
    user_role varchar(10)
);

create table Family(
    user_id varchar(10)  not null,
    relation varchar(10)  not null,
    first_name varchar(30)  not null,
    last_name varchar(30)  not null,
    gender varchar(10)  not null,
    email varchar(50),
    CONSTRAINT PK_Family PRIMARY KEY (user_id, relation, first_name)
);

create table Event(
    id integer primary key auto_increment,
    name varchar(60),
    date_time Date,
    location varchar(100)
);

create table Event_registration(
    event_id varchar(10) references event(id),
    user_id varchar(10) references user(user_id),
    attendance char(1)  not null,
    adult_count integer ,
    below_8 integer,
    between_8_and_12 integer,
    above_12 integer,
    comments varchar(500),
    CONSTRAINT PK_Event_registration PRIMARY KEY (event_id,user_id)
);

create table Event_attendance(
    event_id varchar(10),
    user_id varchar(10),
    actual_attendance char(1),
    payment_id integer references Payment(id),
    CONSTRAINT PK_Event_attendance PRIMARY KEY (event_id,user_id)
);

create table Payment(
    id integer primary key auto_increment,
    type varchar(10),
    amount integer,
    status varchar(10),
    method varchar(15)
);


create table Feedback(
    raised_by integer references user(user_id),
    event_id integer references event(id),
    feedback varchar(500),
    CONSTRAINT PK_Feedback PRIMARY KEY (raised_by, event_id)
);

create table Notice(
    id integer primary key auto_increment,
    content varchar(1000)
);

create table Membership(
    user_id integer references users(user_id),
    membership_year integer,
    payment_id integer references payment(id),
    expiry_date date,
    CONSTRAINT PK_Membership PRIMARY KEY (user_id, membership_year)
);

DELIMITER //
CREATE PROCEDURE GetNextUserId()
BEGIN
    select CONCAT('AMIA',LPAD(max(a.id)+1,5,'0')) user_id from (SELECT SUBSTRING(user_id,5) id FROM User) a;
END
//

DELIMITER ;