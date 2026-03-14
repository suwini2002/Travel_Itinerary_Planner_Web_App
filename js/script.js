

document.addEventListener('DOMContentLoaded', function() {
    
    
    const navbar = document.getElementById('mainNav');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
                navbar.style.backgroundColor = 'rgba(11, 94, 57, 1)';
            } else {
                navbar.classList.remove('shadow-lg');
                navbar.style.backgroundColor = 'rgba(11, 94, 57, 0.95)';
            }
        });
    }

   
    document.querySelectorAll('a.nav-link').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
           
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80, 
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

   
    const destinationForm = document.getElementById('destinationForm');
    const destinationList = document.getElementById('destinationList');
    const emptyState = document.getElementById('emptyState');
    const totalDestinationsSpan = document.getElementById('totalDestinations');
    const totalDaysSpan = document.getElementById('totalDays');
    const clearItineraryBtn = document.getElementById('clearItineraryBtn');
    
    
    let totalDestinations = 0;
    let totalDays = 0;
    
    if (destinationForm) {
        destinationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
            
           
            const destName = document.getElementById('destName').value;
            const travelDate = document.getElementById('travelDate').value;
            const numDays = parseInt(document.getElementById('numDays').value, 10);
            const notes = document.getElementById('travelNotes').value;
            
            
            if (emptyState) {
                emptyState.classList.add('d-none');
            }
            
           
            if (clearItineraryBtn) {
                clearItineraryBtn.classList.remove('d-none');
            }
            
            
            let imgName = 'hero.png';
            if (destName === 'Kandy') imgName = 'kandy.png';
            if (destName === 'Ella') imgName = 'ella.png';
            if (destName === 'Galle') imgName = 'galle.png';
           
            const card = document.createElement('div');
            card.className = 'card trip-card shadow-sm mb-3';
            card.innerHTML = `
                <div class="row g-0">
                    <div class="col-md-3 d-none d-md-block">
                        <img src="images/${imgName}" class="img-fluid rounded-start h-100 object-fit-cover" alt="${destName}">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body position-relative">
                            <button type="button" class="btn-close position-absolute top-0 end-0 m-3 text-danger delete-dest-btn" aria-label="Close"></button>
                            <h5 class="card-title fw-bold text-primary mb-1" style="color: var(--primary-color) !important">${destName}</h5>
                            <div class="d-flex mb-2 flex-wrap">
                                <span class="badge bg-light text-dark me-2 border"><i class="fa-regular fa-calendar me-1"></i>${formatDate(travelDate)}</span>
                                <span class="badge bg-light text-dark border"><i class="fa-regular fa-clock me-1"></i>${numDays} Days</span>
                            </div>
                            <p class="card-text text-muted fst-italic mb-0">${notes || 'No notes provided.'}</p>
                        </div>
                    </div>
                </div>
            `;
            
            
            card.querySelector('.delete-dest-btn').addEventListener('click', function() {
                card.remove();
                totalDestinations--;
                totalDays -= numDays;
                updateSummary();
            });
            
            
            destinationList.appendChild(card);
            
            
            totalDestinations++;
            totalDays += numDays;
            updateSummary();
            
            
            this.reset();
            this.classList.remove('was-validated');
        });
        
        
        if (clearItineraryBtn) {
            clearItineraryBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to clear your entire itinerary?')) {
                    destinationList.innerHTML = '';
                    if (emptyState) {
                        destinationList.appendChild(emptyState);
                        emptyState.classList.remove('d-none');
                    }
                    this.classList.add('d-none');
                    totalDestinations = 0;
                    totalDays = 0;
                    updateSummary();
                }
            });
        }
    }
    
    function updateSummary() {
        if (totalDestinationsSpan) totalDestinationsSpan.textContent = totalDestinations;
        if (totalDaysSpan) totalDaysSpan.textContent = totalDays;
        
        if (totalDestinations === 0 && emptyState) {
            emptyState.classList.remove('d-none');
            if (clearItineraryBtn) clearItineraryBtn.classList.add('d-none');
        }
    }
    
    function formatDate(dateStr) {
        if (!dateStr) return '';
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateStr).toLocaleDateString(undefined, options);
    }

    
    const contactForm = document.getElementById('contactForm');
    const formSuccessAlert = document.getElementById('formSuccessAlert');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
            
           
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
               
                formSuccessAlert.classList.remove('d-none');
                
                
                this.reset();
                this.classList.remove('was-validated');
                
               
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
               
                setTimeout(() => {
                    formSuccessAlert.classList.add('d-none');
                }, 5000);
            }, 1000); 
        });
    }
});
