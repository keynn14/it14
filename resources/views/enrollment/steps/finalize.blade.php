<div class="p-6 border-2 border-green-500 rounded-lg bg-green-50">
    <div class="flex items-center mb-4">
        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-3">6</div>
        <h3 class="text-2xl font-bold text-black-800">FINALIZE</h3>
    </div>
    <div class="bg-white p-6 rounded-lg border border-green-300">
        <h4 class="text-xl font-semibold text-black-700 mb-6 text-center">REVIEW AND SUBMIT</h4>
        <div class="text-center space-y-6">
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                <h5 class="text-lg font-semibold text-black-700">Ready to Submit</h5>
                <p class="text-black-600">Please review all information before submitting</p>
            </div>
            
            <div class="flex items-center justify-center space-x-2">
                <input type="checkbox" id="agreeTerms" class="w-5 h-5" required>
                <label for="agreeTerms" class="text-black-700 font-semibold">I confirm that all information provided is accurate and complete</label>
            </div>
            
           
        </div>
    </div>
</div>

<script>
function submitForm() {
    if (document.getElementById('agreeTerms').checked) {
        // Here you would typically submit the form to your backend
        alert('Student registration submitted successfully!');
        window.location.href = "{{ route('enrollment') }}";
    } else {
        alert('Please confirm that all information is accurate before submitting.');
    }
}
</script>