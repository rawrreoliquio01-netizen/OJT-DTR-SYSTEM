document.addEventListener('DOMContentLoaded', function() {

    const filter = document.getElementById('filter_college');
    const table = document.getElementById('students_table').getElementsByTagName('tbody')[0];

    // Filter by College/Department
    filter.addEventListener('change', function() {
        const selectedCollege = this.value;
        Array.from(table.rows).forEach(row => {
            row.style.display = (!selectedCollege || row.dataset.college === selectedCollege) ? '' : 'none';
        });
    });

    // Handle Update and Delete buttons
    table.addEventListener('click', function(e){
        if(e.target.classList.contains('delete-btn')){
            const studentId = e.target.dataset.id;
            if(confirm("Are you sure you want to delete this student?")){
                fetch('delete_student.php?id=' + studentId)
                    .then(res => res.text())
                    .then(data => {
                        alert(data);
                        e.target.closest('tr').remove();
                    })
                    .catch(error => {
                        alert('Error deleting student: ' + error);
                    });
            }
        }
        
        if(e.target.classList.contains('update-btn')){
            const studentId = e.target.dataset.id;
            window.location.href = 'edit_student.php?id=' + studentId;
        }
    });

});
