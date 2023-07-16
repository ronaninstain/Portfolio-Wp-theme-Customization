jQuery(document).ready(function ($) {
    var modal = $('#project-modal');
    var projectDetailsPlaceholder = $('#project-details-placeholder');

    // Handle click event on project item
    $('.project-item').on('click', function () {
        var projectId = $(this).data('project-id');

        // AJAX request to fetch project details
        $.ajax({
            url: ajax_object.ajax_url,
            method: 'POST',
            data: {
                action: 'load_project_details',
                project_id: projectId
            },
            success: function (response) {
                if (response.success) {
                    projectDetailsPlaceholder.html(response.data);
                    modal.show();
                } else {
                    alert('Failed to load project details.');
                }
            },
            error: function () {
                alert('Failed to load project details.');
            }
        });
    });

    // Close modal on click of close button
    $('.close').on('click', function () {
        modal.hide();
        projectDetailsPlaceholder.html('');
    });

    // Handle sorting projects
    $('#sort-by').on('change', function () {
        var sortBy = $(this).val();

        // AJAX request to sort projects
        $.ajax({
            url: ajax_object.ajax_url,
            method: 'POST',
            data: {
                action: 'sort_projects',
                sort_by: sortBy
            },
            success: function (response) {
                if (response.success) {
                    $('.projects-grid').html(response.data);
                } else {
                    alert('Failed to sort projects.');
                }
            },
            error: function () {
                alert('Failed to sort projects.');
            }
        });
    });

    // Handle filtering projects
    $('#filter-by').on('change', function () {
        var categorySlug = $(this).val();

        // AJAX request to filter projects
        $.ajax({
            url: ajax_object.ajax_url,
            method: 'POST',
            data: {
                action: 'filter_projects',
                category_slug: categorySlug
            },
            success: function (response) {
                if (response.success) {
                    $('.projects-grid').html(response.data);
                } else {
                    alert('Failed to filter projects.');
                }
            },
            error: function () {
                alert('Failed to filter projects.');
            }
        });
    });
});
