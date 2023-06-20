## Problem Statement:

Create a plugin that will be dependent on LearnDash and Category featured image plugins. The plugin should provide a shortcode showing categories and the number of courses in the categories. Use post categories instead of course categories.

The output of the shortcode should be as follows:

![image](https://github.com/arkaprrava-wisdmlabs/task_3/assets/123532079/337a9793-15c3-48b3-b0d5-fbbfdfaccdb2)

The parameter for the shortcode will be:
The number of courses to be displayed at a time - Optional. If this parameter is not used, all categories should show up.
Use this shortcode on a homepage. The "See more" button will be a link to a page where all the categories with the number of courses will be displayed in the same format as above.


## Approach:

1. Check for the plugins are active or not
2. Add image input fields using the ‘ld_course_category_add_form_fields’ in create course categories page and ‘ld_course_category_edit_form_fields’ in edit course categories page
3. Input field will open wordpress media library to select an image and preview it in the page
4. Save the image id in term meta when creating and editing the course categories
5. Use an instance of category featured image plugin class
6. Use ‘manage_edit-ld_course_category_columns’ to add new column in the categories display table using add_term_columns function of the category featured image plugin class and ‘manage_ld_course_category_column’ to add content of the new column added using add_term_custom_column function of the category featured image plugin class 
7. Create a shortcode which takes an integer argument to show the minimum no. of course categories in a page
8. Check for the parameter is empty or not 
9. If empty fetch all course categories
10. Else fetch no. of course categories mentioned in the parameter using taxonomy as “ld_course-category”
11. We will get the term id, term name and the no. of courses in the course category to show them
12. Fetch term meta of the current term using the meta key ‘featured_image_id’ and get the attachment url of the image id
13. If not present set it to default image present in the plugin
14. If all course categories are shown then don’t show the see more button, else show that button
15. Create a ‘Course Category’ page and add the shortcode there without parameter


