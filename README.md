## Problem Statement:

Create a plugin that will be dependent on LearnDash and Category featured image plugins. The plugin should provide a shortcode showing categories and the number of courses in the categories. Use post categories instead of course categories.

The output of the shortcode should be as follows:

![image](https://github.com/arkaprrava-wisdmlabs/task_3/assets/123532079/337a9793-15c3-48b3-b0d5-fbbfdfaccdb2)

The parameter for the shortcode will be:
The number of courses to be displayed at a time - Optional. If this parameter is not used, all categories should show up.
Use this shortcode on a homepage. The "See more" button will be a link to a page where all the categories with the number of courses will be displayed in the same format as above.


## Approach:

1. Check for the plugins are active or not
2. Create a shortcode which takes an integer argument to show the minimum no. of course categories in a page
3. Check for the parameter is empty or not 
4. If empty fetch all course categories
5. Else fetch no. of course categories mentioned in the parameter using taxonomy as “ld_course-category”
6. We will get the term id, term name and the no. of courses in the course category to show them
7. If all course categories are shown then don’t show the see more button, else show that button
8. Create a ‘Course Category’ page and add the shortcode there without parameter

