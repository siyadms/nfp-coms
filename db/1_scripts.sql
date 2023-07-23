
use nfpcodb;

CREATE USER IF NOT EXISTS 'nfpco_user' IDENTIFIED BY 'nfpco_pwd';

GRANT ALL ON nfpcodb.* TO 'nfpco_user' ;
