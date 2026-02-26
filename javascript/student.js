document.addEventListener('DOMContentLoaded', function() {
    const collegeSelect = document.getElementById('college_department');
    const programSelect = document.getElementById('program_select');

    // Initially hide all program options except the default
    Array.from(programSelect.options).forEach(option => {
        if(option.value !== "") {
            option.style.display = 'none';
        }
    });

    collegeSelect.addEventListener('change', function() {
        const selectedCollege = this.value;
        
        // Hide all program options first
        Array.from(programSelect.options).forEach(option => {
            if(option.value !== "") {
                option.style.display = 'none';
            }
        });
        
        // Show only programs belonging to the selected college
        if(selectedCollege) {
            Array.from(programSelect.options).forEach(option => {
                if(option.value !== "" && option.dataset.college === selectedCollege){
                    option.style.display = '';
                }
            });
        }
        
        // Reset program selection
        programSelect.value = "";
    });
});
