document.getElementById('levels').addEventListener('change', function() {
  fetchAndPopulateClasses(this.value);
});

function fetchAndPopulateClasses(gradeLevel) {
  var classSelect = document.getElementById('class');
  var classesDropdown = document.getElementById('classes');

  if (gradeLevel !== "") {
      fetch('getters-php/get-classes.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'gradeLevel=' + encodeURIComponent(gradeLevel)
      })
      .then(response => response.json())
      .then(data => {
          classesDropdown.innerHTML = '<option value="">Select Class</option>';
          data.forEach(classItem => {
              var option = document.createElement('option');
              option.value = classItem.code;
              if (classItem['educ-level'] === "Vocational Course") {
                option.text = classItem.name + " (" + classItem.title + ")";
              } else if (classItem['educ-level'] === "Others") {
                option.text = classItem.name + " (" + classItem.type + ")";
              } else if (classItem['educ-level'] === "Senior Highschool") {
                option.text = classItem.name + " (" + classItem.strand + ")";
              } else {
                option.text = classItem.name;
              }
              classesDropdown.appendChild(option);
          });
          classSelect.style.display = 'block';
      })
      .catch(error => console.error('Error:', error));
  } else {
      classSelect.style.display = 'none';
  }
}


  function fetchOptions(url, callback) {
    fetch(url)
      .then(response => response.json())
      .then(data => callback(data))
      .catch(error => console.error('Error fetching data:', error));
  }

  document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const barangaySelect = document.getElementById('barangay');

    function populateDropdown(select, options, placeholder = "Select an option") {
      select.innerHTML = `<option value="">${placeholder}</option>`;
      options.forEach(option => {
        const opt = document.createElement("option");
        opt.value = option.provCode; 
        opt.textContent = option.provDesc;
        select.appendChild(opt);
      });
    }

    function fetchDropdownData(url, callback) {
      fetch(url)
        .then(response => response.json())
        .then(data => callback(data))
        .catch(error => console.error('Error fetching data:', error));
    }

    fetchDropdownData('getters-php/get-province.php', function(provinces) {
      populateDropdown(provinceSelect, provinces);
    });

    provinceSelect.addEventListener('change', function() {
      const selectedProvinceId = this.value;
      citySelect.innerHTML = '<option value="">Select City</option>'; 

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

  document.addEventListener('DOMContentLoaded', function(){
    const currentYear = new Date().getFullYear();
    const randomNumber = Math.floor(Math.random() * 1000000);
    const StudentId = `${currentYear}${randomNumber}`;
    var IDfield = document.getElementById('studentno');

    IDfield.value = StudentId;
  })
  
    const birthdateField = document.getElementById('birthdate');
    const ageField = document.getElementById('age');

    birthdateField.addEventListener('input', function() {
        const birthdate = new Date(birthdateField.value);
        const age = calculateAge(birthdate);

        if (age <= 0) {
            alert("Please enter a valid birthdate.");
            birthdateField.value =''; 
            ageField.value = '';
        } else {
            ageField.value = age;
        }

    function calculateAge(birthdate) {
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        const monthDifference = today.getMonth() - birthdate.getMonth();

        // If the birth date hasn't occurred yet this year, subtract one from age
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }

        return age;
    }
});

document.addEventListener('DOMContentLoaded', function() {
  // Get all input elements of type text
  var textInputs = document.querySelectorAll('input[type="text"]');

  // Function to capitalize the first letter of each word
  function capitalizeWords(input) {
    let words = input.value.split(' ');
    for (let i = 0; i < words.length; i++) {
      if (words[i].length > 0) {
        words[i] = words[i][0].toUpperCase() + words[i].substring(1);
      }
    }
    input.value = words.join(' ');
  }

  // Add event listeners to each text input element
  textInputs.forEach(function(input) {
    input.addEventListener('input', function() {
      capitalizeWords(input);
    });
  });
});


