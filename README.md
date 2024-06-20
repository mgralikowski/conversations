Try out and compare solutions to fetch models filtered and ordered by sub-relationship.
The test example is conversations with participants and messages, and our goal is to return JSON with the 25 most recent conversations with the last message.

Requirements:
- PHP 8.3
- MySQL/MariaDB

Results:

# Data (seeders)

![image](https://github.com/mgralikowski/conversations/assets/17027876/f995c535-16ce-4b69-afe7-722cce445ff2)

# /user/conversations/max
![image](https://github.com/mgralikowski/conversations/assets/17027876/570eb0c5-f3f7-49ad-829b-663c527c2102)

# /user/conversations/join
![image](https://github.com/mgralikowski/conversations/assets/17027876/217f1508-511f-49a3-8eeb-0c7f6e675480)

# /user/conversations/eloquent
![image](https://github.com/mgralikowski/conversations/assets/17027876/c06bb21c-4433-4d6d-b10d-b290adaea909)

All 3 JSON responses are the same - the 25 latest conversations objects with the `last_message` object containing content also the child relation - the user profile of the author of this message.
Powered by: <p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
