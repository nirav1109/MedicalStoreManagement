# MedicalStoreManagement
This site simply manage the stock of medicines and send reminder to customer regarding medicines is over message and send bill in mail and also print the bill


step to run:

1) To this site import strore.sql file.
2) add email and password in users named table manually.


for sending mail thourgh smtp you have to following changes
1) go to  
   xampp > php > PHP - INI DEVELOPMENT 
   xampp > php > PHP - INI PRODUCTION
   
you have to remove (;) semicolon before openssl in above 2 file (php ini production and php ini development)



and then add your email and password in SendBillToMail.php and Mail.php (there is commented).

