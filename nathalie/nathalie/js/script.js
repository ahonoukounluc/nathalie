
  (function($) {
    $(document).ready(function() {
      let photosData = null
      $.ajax({
        type: "POST",
        url:  ajax_object.ajax_url,
        data: {
          action: "filter_photos"
        },
        dataType: "json",
        success: function(data) {
          photosData = data;
          showFilters()
        },
      });

      function showFilters() {
        if (photosData) {                  
          const categories = photosData.all_categorie;
          const formats = photosData.all_format;
          if (categories) {
            for (let index = 0; index < categories.length; index++) {
              const categorie = categories[index];
              var content = `<li class="list-tag"> ${categorie} </li>`;
              content += '</li>';
              $('.filter-category').append(content);
            }
          }
          if (formats) {
            for (let index = 0; index < formats.length; index++) {
              const format = formats[index];
              var content = `<li class="list-format"> ${format} </li>`;
              content += '</li>';
              $('.filter-format').append(content);
            }
          }
        }
      }
    });
  })(jQuery);
 
  