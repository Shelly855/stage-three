# Digital Preoperative Assessment Pathway and Clinical Decision Support System
**Project Duration:** Mar 4th - Apr 23rd 2024

This project was developed as part of a 1st-year university assignment, with **AZ Hospital Trust** as a hypothetical client. The patients at AZ Hospital Trust each have 1-hour appointments, leading to a lengthy surgical waiting list and affecting their eligibility for surgery. The hospital's preoperative assessment (POA) process was previously inefficient, with a lot of time spent assessing patients who did not need appointments.

## Objective
To create a system that could streamline the POA process by identifying patients who need early assessments.

## Solution  
A web application that allows patients to complete the POA questionnaire, making the assessment process more efficient in identifying patients who require appointments.

## Database
- SQLite

## Possible Improvements
- Adding code comments
- Improving Review Answers page for patient users
- Improving Review Answers page for doctor users

## How To Run
1. Clone the repository (e.g., in Visual Studio Code) and save it in the **htdocs** directory inside your **XAMPP** folder
2. Open **XAMPP** and start both the **Apache** and **MySQL** servers
3. Use **DB Browser for SQLite** (or a similar tool) to import the **.sql** file and initialise the database.
4. Save the database file, which is called **stage-three**, in a folder called **data** inside your **XAMPP** folder
5. Open a browser and go to: **localhost/stage-three/login/login.php**

## Dummy Login Credentials
### Doctor Login
- Username: **Will23**
- Password: **password1**

### Patient Login
- Username: **Beth11**
- Password: **4rghs8A**

### Admin Login
- Username: **Sarah12**
- Password: **password3**
