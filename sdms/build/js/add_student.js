function clearClassDropdowns() {
  document.getElementById('elementaryClasses').innerHTML = '<option value="">Select Class/Section</option>';
  document.getElementById('middleClasses').innerHTML = '<option value="">Select Class/Section</option>';
  document.getElementById('highClasses').innerHTML = '<option value="">Select Class/Section</option>';
  document.getElementById('elementaryClass').style.display = 'none';
  document.getElementById('middleClass').style.display = 'none';
  document.getElementById('highClass').style.display = 'none';
}


document.getElementById('elementaryGrade').addEventListener('change', function() {
  clearClassDropdowns();
  fetchAndPopulateClasses(this.value, 'elementary');
});

document.getElementById('middleGrade').addEventListener('change', function() {
  clearClassDropdowns();
  fetchAndPopulateClasses(this.value, 'middle');
});

document.getElementById('highGrade').addEventListener('change', function() {
  clearClassDropdowns();
  fetchAndPopulateClasses(this.value, 'high');
});

function fetchAndPopulateClasses(gradeLevel, levelType) {
  var classSelect = document.getElementById(`${levelType}Class`);
  var classesDropdown = document.getElementById(`${levelType}Classes`);

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
      classesDropdown.innerHTML = '<option value="">Select Class/Section</option>';
      data.forEach(classItem => {                                            
        var option = document.createElement('option');                                                                                            
        option.value = classItem.code;
        option.text = classItem.name;
        classesDropdown.appendChild(option);
      });
      classSelect.style.display = 'block';
    })
    .catch(error => console.error('Error:', error));
  } else {
    classSelect.style.display = 'none';
  }
}

  document.getElementById('levels').addEventListener('change', function() {
    const selectedGrade = this.value;
    document.getElementById('elementaryGrades').style.display = 'none';
    document.getElementById('middleGrades').style.display = 'none';
    document.getElementById('highGrades').style.display = 'none';
    document.getElementById('strand').style.display = 'none';
    document.getElementById('programs').style.display = 'none';
    clearClassDropdowns();

    if (selectedGrade === 'elementary') {
      document.getElementById('elementaryGrades').style.display = 'block';
      document.getElementById('strand').style.display = 'none';
    } else if (selectedGrade === 'Junior High') {
      document.getElementById('middleGrades').style.display = 'block';
      document.getElementById('strand').style.display = 'none';
    } else if (selectedGrade === 'Senior High') {
      document.getElementById('highGrades').style.display = 'block';
      document.getElementById('strand').style.display = 'block';
    } else if (selectedGrade === "Vocational") {
      document.getElementById('programs').style.display = 'block';
      document.getElementById('strand').style.display = 'none';
    }
  });

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
  document.addEventListener('DOMContentLoaded', function() {
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
    });

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