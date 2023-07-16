// select the element
const counters = document.querySelectorAll('.counter');

// iterate through all the counter elements
counters.forEach(counter => 
    {
    // function to increment the counter
    function updateCount() 
    {
        const target = +counter.getAttribute('data-count');
        const count = +counter.innerHTML;

        const inc = Math.floor((target - count) / 100);

        if (count < target && inc > 0) 
        {
            counter.innerHTML = (count + inc);
            // repeat the function
            setTimeout(updateCount, 1);
        }
        // if the count not equal to target, then add remaining count
        else 
        {
        counter.innerHTML = target;
        }
    }
   updateCount();
});