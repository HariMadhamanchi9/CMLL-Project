# CMLL(Classical And Modren Langages And Literatures Dpt @TTU ) -Web Application

Classical & Modern Languages & literatues Department  
The TTU Department of Classical & Modern Languages & Literatures is dedicated to equipping you for the world through language and culture 
Teaches Greek, ASL, Japanees, Kerean , Latin, Mandarin Chinese, Russain, spanish etc. where students learn different languages. 

 There is a dedicated Lab where students taugth diffrenet langauges by professors, studnet do there assignments, watch movies, ALS Training, Language Test/.Exams  are been conducted with in the Lab 

 so, to keep track of all these necessary information related to students,Professors the management created the Manual Sheet. where studnet need to write down there R-numebr, first name, lastname, and purpose of there visit and the check-in and check out time . 
 
![Image](https://github.com/HariMadhamanchi9/CMLL-Project/assets/82075476/a3184dbe-31a5-4653-9e6b-14d0ccc13562)

But due to increse in no.of students visiting the lab (1000+ every month ) and the ambiguity and inconsistancy in Data with in the manual sheet the CMLL Department thends to change the manual sheet to a Web application.  
SO, web App is mailny focusing on the removign the manual student traking system used by the lab to track of students vistinig the Dpt lab. 

The Web Application Keep track of students detials, there purpose of visit and tracks the no.of hours that studnets spends in the lab. Also track the Professor Class Detials. 
On the other Hand I have created other Web App to moniter the Daily Activce users where we can track the no.of students visiting the lab daily . 

CMLL-Project is the main folder 
sub folders 
1.Active users  Folder - Displays the No.of students visited the Lab daly. Refreshes every 5 min to keep trak of new students visiting the Lab 
2. CMLL PROHECT PROD  - Has the Actual code to keep track of students, Professors, feed back of the students and professors. 
3. Visual Studio   - has the backgrounbd images for the web app
4. Update users details - seperate Web App to update the users dertails rather than updating in Sql 

Work-Flow:

1. Displays  Log.html page to studnents
2. User enters Rnumber
3. If Rnumber is in the "users" table:
   - Redirect to login.html
   - User enters purpose of visit
   - Data is processed in processcheckin.php
   - Information is stored in Checkins table  (R-number, purpose of visit, first name, last name, check-in time, checkout time, there img url  )
   - Redirect to success.php - haiving user name 
   - After 3 seconds, redirect back to Log.html
4. If Rnumber is not in the "users" table:
   - Redirect to signup.html
   - User enters first name, last name, and purpose
   - Data is stored in Checkins and Users tables (R-number, purpose of visit, first name, last name, check-in time, checkout time, there img url  )
   - Redirect to success.php
   - After 3 seconds, redirect back to Log.html
5. If the same user visits within 3 hours:
   - enters there R-numer in log.html
   - checks weather the studets is been logged in in the data base and it automatically logout him and capture the check out time , img add it to the checkins table)
   - Redirect to checkout.php
   - User provides feedback ( feed back is anonymus ) 
   - Feedback is stored in the feedback table
   - Redirect to feedback_success.html
   - After 3 seconds, redirect back to Log.html

6. Professor logs in:
   - Redirect to professorlogin.html
   - Professor enters name
   - Name is searched in professor_search.php
   - Redirect to professorlogin.php
   - Updates professor_checkins table
   - Redirects to professorview.html
   - Professor enters purpose
   - Data is processed in professorview.php
   - Updates professor_checkins table
   - Redirect to professor_successpage.php
   - After 3 seconds, redirect back to Log.html
7. If the same professor logs in within 3 hours:
   - Redirect to professorreview.html
   - Professor enters feedback
   - Feedback is stored in professor_feedback table
   - Redirect to feedback_success.html
   - After 3 seconds, redirect back to Log.html
8. If any user or professor returns after 3 hours:
   - Their feedback is automatically submitted
   - The relevant pages for check-in are shown.

Normal flow of checkin and check out if studnet is been in the database 
details capture in database checkins table are : R-number, first name, last name, purpose of visit, chekcin image URL, checkout image URL  

![1](https://github.com/HariMadhamanchi9/CMLL-Project/assets/82075476/babbdfa9-eadb-4f69-b565-1b9e4eecdf0a)
![2](https://github.com/HariMadhamanchi9/CMLL-Project/assets/82075476/5df69b28-b3bf-479c-87b3-36e1b86cd779)
![3](https://github.com/HariMadhamanchi9/CMLL-Project/assets/82075476/eb328950-3edf-4975-b5b2-60ab45637893)
![5](https://github.com/HariMadhamanchi9/CMLL-Project/assets/82075476/3690fe1a-5c34-447f-b50d-a99da139fbdb)
![6](https://github.com/HariMadhamanchi9/CMLL-Project/assets/82075476/057906ed-e363-4efd-a139-0fac026b71a1)



