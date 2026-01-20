<!-- Prevent Double Form Submission Component -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                // Find all submit buttons in this form
                const submitButtons = form.querySelectorAll('button[type="submit"]');
                
                // Disable all submit buttons
                submitButtons.forEach(button => {
                    button.disabled = true;
                    button.classList.add('opacity-50', 'cursor-not-allowed');
                    // Add loading state text if available
                    const originalText = button.textContent;
                    button.dataset.originalText = originalText;
                    button.textContent = 'Processing...';
                });
                
                // Store submission state
                form.dataset.submitted = 'true';
            });

            // Reset form if user goes back (for browser back button)
            form.addEventListener('reset', function() {
                const submitButtons = form.querySelectorAll('button[type="submit"]');
                submitButtons.forEach(button => {
                    button.disabled = false;
                    button.classList.remove('opacity-50', 'cursor-not-allowed');
                    if (button.dataset.originalText) {
                        button.textContent = button.dataset.originalText;
                    }
                });
                form.dataset.submitted = 'false';
            });
        });
    });
</script>
