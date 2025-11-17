<section class="faq-section" id="faq-section">
    <div class="faq-container">
        <!-- FAQ Header -->
        <div class="faq-header">
            <h1 class="faq-title">Frequently Asked Questions</h1>
            <p class="faq-subtitle">Everything you need to know about our social media management services</p>
        </div>
        <!-- FAQ Accordion -->
        <div class="faq-accordion">
            @foreach ($questions as $question)
                <div class="faq-item">
                    <button class="faq-question" type="button" data-faq-toggle>
                        <span class="faq-question-text">{{ $question->question }}</span>
                        <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-answer" data-faq-content>
                        <div class="faq-answer-inner">
                            {!! $question->answer !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqItems = document.querySelectorAll('[data-faq-toggle]');
        faqItems.forEach(function(button) {
            button.addEventListener('click', function() {
                const faqItem = this.closest('.faq-item');
                const content = faqItem.querySelector('[data-faq-content]');
                const icon = this.querySelector('.faq-icon');
                const isOpen = faqItem.classList.contains('active');
                // Close all other items
                document.querySelectorAll('.faq-item.active').forEach(function(item) {
                    if (item !== faqItem) {
                        item.classList.remove('active');
                        item.querySelector('[data-faq-content]').style.maxHeight = null;
                        item.querySelector('.faq-icon').style.transform =
                            'rotate(0deg)';
                    }
                });
                // Toggle current item
                if (isOpen) {
                    faqItem.classList.remove('active');
                    content.style.maxHeight = null;
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    faqItem.classList.add('active');
                    content.style.maxHeight = content.scrollHeight + 'px';
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        });
    });
</script>