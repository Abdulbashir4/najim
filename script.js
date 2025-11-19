// Drawer menu toggle
function drawer_menu() {
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('active'); // drawer toggle
}

// নতুন function: drawer close
function closeDrawer() {
  const sidebar = document.querySelector('.for_sidebar');
  sidebar.classList.remove('active'); // drawer বন্ধ
}
    

// লোকাল page দেখানো
function showPage(pageId) {
    // সব লোকাল page hide
    var pages = document.querySelectorAll('.page');
    pages.forEach(function(page) {
        page.style.display = "none";
    });

    // শুধু নির্বাচিত page দেখানো
    var selectedPage = document.getElementById(pageId);
    if (selectedPage) {
        selectedPage.style.display = "flex";
    }

    // contentArea সবসময় hide থাকবে (কারণ এটা external load এর জন্য)
    let contentArea = document.getElementById("contentArea");
    if (contentArea) contentArea.style.display = "none";
    closeDrawer();
}

// বাইরের page লোড করা
function loadPage(page) {
    fetch(page)
        .then(res => res.text())
        .then(html => {
            let temp = document.createElement("div");
            temp.innerHTML = html;

            let newContent = temp.querySelector(".page-content");
            let contentArea = document.getElementById("contentArea");

            if (contentArea) {
                if (newContent) {
                    contentArea.innerHTML = newContent.innerHTML;
                } else {
                    contentArea.innerHTML = "No content found!";
                }
                contentArea.style.display = "block"; // visible করো
            }
        })
        .catch(err => {
            let contentArea = document.getElementById("contentArea");
            if (contentArea) {
                contentArea.innerHTML = "Error loading page!";
                contentArea.style.display = "block";
            }
            console.error(err);
        });

    // অন্য সব লোকাল page hide করো
    safeHide('add_employee');
    safeHide('Add_customer');
    safeHide('payment');
    safeHide('sale_page');
    closeDrawer();
}

function safeHide(id) {
    let el = document.getElementById(id);
    if (el) el.style.display = "none";
}

// Print
function printDiv(divId) {
    let content = document.getElementById(divId).innerHTML;
    let myWindow = window.open('', '', 'width=800,height=600');
    myWindow.document.write('<html><head><title>Print</title></head><body>');
    myWindow.document.write(content);
    myWindow.document.write('</body></html>');
    myWindow.document.close();
    myWindow.print();
}

// Delete
function deleteData(table, id) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location = 'delete.php?table=' + table + '&id=' + id;
    }
}

// Edit
function editData(table, id) {
    window.location = 'edit.php?table=' + table + '&id=' + id;
}



// slider start here
(function(){
      const slider = document.getElementById('slider');
      const slidesEl = document.getElementById('slides');
      const slides = Array.from(slidesEl.children);
      const prevBtn = document.getElementById('prev');
      const nextBtn = document.getElementById('next');
      const dotsEl = document.getElementById('dots');

      let index = 0;
      const total = slides.length;
      let autoplay = true;
      let intervalMs = 4000; // auto-advance interval
      let timer = null;
      let isDragging = false;
      let startX = 0, currentX = 0;

      // build dots
      slides.forEach((s,i)=>{
        const dot = document.createElement('button');
        dot.className = 'dot';
        dot.setAttribute('aria-label', 'Go to slide '+(i+1));
        dot.setAttribute('role','tab');
        dot.addEventListener('click', ()=>goTo(i));
        dotsEl.appendChild(dot);
      });

      const dots = Array.from(dotsEl.children);

      function update(){
        slidesEl.style.transform = `translateX(${ -index * 100 }%)`;
        dots.forEach((d, i)=> d.classList.toggle('active', i===index));
      }

      function prev(){ index = (index - 1 + total) % total; update(); }
      function next(){ index = (index + 1) % total; update(); }
      function goTo(i){ index = (i + total) % total; update(); }

      prevBtn.addEventListener('click', ()=>{ prev(); restartTimer(); });
      nextBtn.addEventListener('click', ()=>{ next(); restartTimer(); });

      // keyboard
      document.addEventListener('keydown', (e)=>{
        if(e.key === 'ArrowLeft') { prev(); restartTimer(); }
        if(e.key === 'ArrowRight'){ next(); restartTimer(); }
      });

      // autoplay
      function startTimer(){ if(!autoplay) return; stopTimer(); timer = setInterval(()=>{ next(); }, intervalMs); }
      function stopTimer(){ if(timer) clearInterval(timer); timer = null; }
      function restartTimer(){ stopTimer(); startTimer(); }

      // pause on hover/focus
      slider.addEventListener('mouseenter', ()=> stopTimer());
      slider.addEventListener('mouseleave', ()=> startTimer());
      slider.addEventListener('focusin', ()=> stopTimer());
      slider.addEventListener('focusout', ()=> startTimer());

      // touch / swipe support (basic)
      slidesEl.addEventListener('touchstart', (e)=>{
        isDragging = true; startX = e.touches[0].clientX; currentX = startX; stopTimer();
      }, {passive:true});

      slidesEl.addEventListener('touchmove', (e)=>{
        if(!isDragging) return; currentX = e.touches[0].clientX;
        const dx = currentX - startX;
        // small drag effect
        slidesEl.style.transform = `translateX(${ -index * 100 + (dx / slider.clientWidth) * 100 }%)`;
      }, {passive:true});

      slidesEl.addEventListener('touchend', (e)=>{
        if(!isDragging) return; isDragging=false; const dx = currentX - startX;
        if(Math.abs(dx) > 40){ if(dx < 0) next(); else prev(); } else update(); startTimer();
      });

      // prevent image drag ghost
      slides.forEach(imgWrap => {
        const img = imgWrap.querySelector('img');
        if(img) img.ondragstart = ()=> false;
      });

      // init
      update(); startTimer();

      // expose a small API on the DOM element (optional)
      slider.sliderAPI = { next, prev, goTo, startTimer, stopTimer };

      // make slider responsive on resize (re-apply transform)
      window.addEventListener('resize', ()=> update());

    })();


    // for customer page 
   function hide_show(){
      let hideShow = document.getElementById("alert_box");
      hideShow.classList.toggle('cls16');
    }

function search_customer(){
   let customer_id = document.getElementById('customer_id').value;
   if(customer_id === ""){
    alert("Please Give Customer ID");
    return;
   }
   else{
    window.location.href="customer_payment_report.php?customer_id=" + customer_id;
   }
}