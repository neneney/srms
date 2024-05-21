var images = document.querySelectorAll('img');
images.forEach(function(image) {
  image.addEventListener('click', function(event) {
    event.preventDefault();
    event.stopPropagation();
    if (image.contains(event.target)) {
      image.classList.toggle('enlarged-image');
    } else {
      image.classList.remove('enlarged-image');
    }
  });
});

document.addEventListener('click', function(event) {
  var images = document.querySelectorAll('#studentImage');

  images.forEach(function(img) {
    var isClickedInsideImage = event.target === img || img.contains(event.target);

    if (!isClickedInsideImage) {
      img.classList.remove('enlarged-image');
    }
  });
});

$(document).ready(function() {
  $(document).on('click', '.edit_data', function() {
    var edit_id = $(this).attr('id');
    $.ajax({
      url: "edit_student.php",
      type: "post",
      data: {
        edit_id: edit_id
      },
      success: function(data) {
        $("#info_update").html(data);
        $("#editData").modal('show');
      }
    });
  });
});

$(document).ready(function() {
  $(document).on('click', '.edit_data2', function() {
    var edit_id2 = $(this).attr('id');
    $.ajax({
      url: "view_student_info.php",
      type: "post",
      data: {
        edit_id2: edit_id2
      },
      success: function(data) {
        $("#info_update2").html(data);
        $("#editData2").modal('show');
      }
    });
  });
});

function printCert() {
  var printContents = document.getElementById('certificateModal').innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}

document.addEventListener('DOMContentLoaded', function() {
  $('#editData').on('shown.bs.modal', function() {
    const provinceSelect = document.getElementById('province1');
    const citySelect = document.getElementById('city1');
    const barangaySelect = document.getElementById('barangay1');

 

    function populateDropdown(select, options) {
      
      options.forEach(option => {
        const opt = document.createElement("option");
        opt.value = option.provCode; // Adjust this based on actual data keys
        opt.textContent = option.provDesc; // Adjust this based on actual data keys
        select.appendChild(opt);
      });
    }

    function fetchDropdownData(url, callback) {
      fetch(url)
        .then(response => response.json())
        .then(data => {
          callback(data);
        })
        .catch(error => console.error('Error fetching data:', error));
    }

    fetchDropdownData('getters-php/get-province.php', function(provinces) {
      populateDropdown(provinceSelect, provinces);
    });

    provinceSelect.addEventListener('change', function() {
      const selectedProvinceId = this.value;
      citySelect.innerHTML = '<option value="">Select City</option>';
      barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
      if (selectedProvinceId) {
        fetchDropdownData(`getters-php/get-cities.php?province_id=${selectedProvinceId}`, function(cities) {
          cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.citymunCode;
            option.textContent = city.citymunDesc;
            citySelect.appendChild(option);
          });
        });
      }
    });

    citySelect.addEventListener('change', function() {
      barangaySelect.innerHTML = "<option value=''>Select Barangay</option>";
      if (this.value) {
        fetchDropdownData(`getters-php/get-barangay.php?city_id=${this.value}`, function(barangays) {
          barangays.forEach(barangay => {
            const option = document.createElement('option');
            option.value = barangay.brgyCode;
            option.textContent = barangay.brgyDesc;
            barangaySelect.appendChild(option);
          });
        });
      }
    });
  });
});

