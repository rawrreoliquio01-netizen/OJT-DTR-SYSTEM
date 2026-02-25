// Mapping programs by college
const programsByCollege = {
  "CASTech": [
    "BS Agriculture",
    "BS Forestry",
    "BS Fisheries",
    "BS Agricultural Technology"
  ],
  "CAS": [
    "BA English Language Studies",
    "BS Biology",
    "BS Mathematics"
  ],
  "CBEE": [
    "BS Agricultural Business",
    "BS Entrepreneurship",
    "BS Hospitality Management",
    "BS Food Technology"
  ],
  "COED": [
    "BEEd – Elementary Education",
    "BSEd – Secondary Education",
    "BPED – Physical Education",
    "BTVTEd – Technology & Livelihood Education"
  ],
  "CoECS": [
    "BS Agricultural & Biosystems Engineering",
    "BS Civil Engineering",
    "BS Computer Engineering",
    "BS Information Technology",
    "BS Geodetic Engineering"
  ],
  "CVM": ["Doctor of Veterinary Medicine"]
};

// DOM elements
const collegeSelect = document.getElementById("college_department");
const programSelect = document.getElementById("program");

// Update programs when college changes
collegeSelect.addEventListener("change", () => {
  const selectedCollege = collegeSelect.value;
  programSelect.innerHTML = "<option value='' disabled selected>Select Program</option>";

  if (programsByCollege[selectedCollege]) {
    programsByCollege[selectedCollege].forEach(prog => {
      const opt = document.createElement("option");
      opt.value = prog;
      opt.textContent = prog;
      programSelect.appendChild(opt);
    });
  }
});
