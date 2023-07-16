# Portfolio Projects WordPress Theme Documentation

# Custom Post Type (CPT) - Projects:

The Portfolio Projects theme introduces a custom post type called "Projects" to showcase portfolio projects. To add a new project:

From the WordPress dashboard, navigate to "Projects" > "Add New".
Enter the project details, including the title, description, thumbnail image, external URL (optional), and preview images (optional) using the provided fields.
Publish the project.

# Displaying Projects:

The theme provides a projects page that displays all the projects in a grid layout. To access the projects page:

Create a new page from the WordPress dashboard.
Assign the "Projects Page" template to the page.
Publish the page.
View the page to see all the projects with their respective thumbnail images, titles, and categories.

# Sorting and Filtering Projects:

The projects page includes sorting and filtering functionality to help users navigate and find specific projects:

Sorting: The projects can be sorted by title or category. Use the "Sort by" dropdown to select the sorting option.
Filtering: The projects can be filtered by category. Use the "Filter by Category" dropdown to select a specific category.

# Single Project View (Modal):

When a user clicks on a project in the grid, a detailed view of the project opens in a modal:

The modal displays the project's title, description, thumbnail image, external URL (if available), and preview images (if available).
To close the modal, click the "X" button or anywhere outside the modal.

# Setup and Configuration:

To set up and configure the Portfolio Projects theme, follow these steps:

Install and activate the theme on your WordPress website.
Create a page using the "Projects Page" template to display the projects.
Create individual projects using the "Projects" custom post type.
Assign categories to the projects if desired.
Customize the theme's CSS file (style.css) to match your desired design.

# Code Explanation:

The theme utilizes WordPress functions, custom post types, custom meta boxes, and AJAX to achieve the desired features. The custom post type "Projects" allows you to store project information, including the title, description, thumbnail image, external URL, and preview images. The theme's template files (projects-page.php and project-item.php) handle the display of projects and project details. The JavaScript file (portfolio-scripts.js) handles the AJAX requests for loading project details and implementing sorting and filtering functionality. The CSS file (style.css) provides the necessary styles for the project page and project detail modal.

Please follow the steps outlined in the documentation to effectively utilize the features of the Portfolio Projects WordPress theme.
