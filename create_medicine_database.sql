##create database
create database medicine;
##create a user name=mdc pw=mdc123
GRANT usage on medicine.* to mdc identified by 'mdc123';
##grant previleges
GRANT select, insert, update, delete, index, alter, create, drop on medicine.* to mdc;

##pw is mdc123
##mysql -u mdc -p -D medicine