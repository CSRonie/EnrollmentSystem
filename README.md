## Users and Roles Summary

| Username          | Role              | Specific Role     | Email                        | Description of Role                              |
|--------------------|-------------------|-------------------|------------------------------|------------------------------------------------|
| `admin_user`       | Admin             | Super Admin       | admin@example.com            | Full control over the system                   |
| `faculty_user`     | Faculty           | Professor         | faculty@example.com          | Teaching staff with research responsibilities  |
| `registrar_user`   | Registrar         | Registrar         | registrar@example.com        | Manages student records and enrollment         |
| `building_manager` | Building Manager  | Building Manager  | building_manager@example.com | Handles building and infrastructure information |


--------------------------------------------------------
  HOW TO RUN THIS PROJECT IN XAMPP (LOCAL SERVER)
--------------------------------------------------------

1. Install XAMPP (if you haven't already):
   - Download XAMPP from https://www.apachefriends.org/download.html
   - Follow the installation instructions for your operating system.

2. Move Project Files to XAMPP's htdocs Folder:
   - Locate your XAMPP installation directory.
   - Inside the XAMPP folder, open the `htdocs` directory.
   - Copy the entire project folder (containing your project files) into the `htdocs` directory.
     For example, it should be located like:
     C:\xampp\htdocs\capst\

3. Start XAMPP:
   - Open the XAMPP Control Panel.
   - Start the Apache server by clicking "Start" next to "Apache".

4. Access the Project in a Web Browser:
   - Open a web browser (such as Chrome, Firefox, etc.).
   - In the address bar, type: `http://localhost/capst/Welcome` and press Enter.
   - You should now be able to view and interact with your project locally.

5. Troubleshooting (if needed):
   - If Apache doesn't start, check if another application (like Skype) is using port 80. You can change the Apache port in the XAMPP settings.
   - Ensure that your project files are correctly placed inside `htdocs` and that there are no typos in the folder name.
