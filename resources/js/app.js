import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    /*
    |--------------------------------------------------------------------------
    | Hero Typing Animation
    |--------------------------------------------------------------------------
    */

    const typingText = document.getElementById('pk-typing-text');
    const typingCursor = document.getElementById('pk-typing-cursor');

    if (typingText) {
        const words = [
            'Bisnis',
            'Kebutuhan',
            'Project',
            'Impian',
            'Pekerjaan',
        ];

        let wordIndex = 0;
        let charIndex = 0;
        let deleting = false;

        const typeSpeed = 90;
        const deleteSpeed = 50;
        const holdAfterTyping = 1800;
        const holdAfterDeleting = 400;

        const reducedMotion = window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;

        /*
        |--------------------------------------------------------------------------
        | Reduced Motion
        |--------------------------------------------------------------------------
        */

        if (reducedMotion) {
            typingText.textContent = words[0];
        } else {
            /*
            |--------------------------------------------------------------------------
            | Typing Loop
            |--------------------------------------------------------------------------
            */

            const typeLoop = () => {
                const currentWord = words[wordIndex];

                /*
                |--------------------------------------------------------------------------
                | Mengetik
                |--------------------------------------------------------------------------
                */

                if (!deleting) {
                    charIndex += 1;

                    typingText.textContent =
                        currentWord.substring(0, charIndex);

                    if (charIndex >= currentWord.length) {
                        setTimeout(() => {
                            deleting = true;
                            typeLoop();
                        }, holdAfterTyping);

                        return;
                    }

                    setTimeout(typeLoop, typeSpeed);

                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | Menghapus
                |--------------------------------------------------------------------------
                */

                charIndex -= 1;

                typingText.textContent =
                    currentWord.substring(0, charIndex);

                if (charIndex <= 0) {
                    charIndex = 0;
                    deleting = false;

                    wordIndex =
                        (wordIndex + 1) % words.length;

                    setTimeout(
                        typeLoop,
                        holdAfterDeleting
                    );

                    return;
                }

                setTimeout(
                    typeLoop,
                    deleteSpeed
                );
            };

            /*
            |--------------------------------------------------------------------------
            | Delay awal
            |--------------------------------------------------------------------------
            */

            setTimeout(typeLoop, 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Typing Cursor
    |--------------------------------------------------------------------------
    */

    if (typingCursor) {
        const reducedMotion = window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;

        if (reducedMotion) {
            typingCursor.style.display = 'none';
        } else {
            setInterval(() => {
                typingCursor.style.opacity =
                    typingCursor.style.opacity === '0'
                        ? '1'
                        : '0';
            }, 550);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Homepage Scroll Reveal
    |--------------------------------------------------------------------------
    */

    const revealItems =
        document.querySelectorAll(
            '.pk-home-reveal'
        );

    if (!revealItems.length) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Reduced Motion
    |--------------------------------------------------------------------------
    */

    const reduceMotion =
        window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;

    if (reduceMotion) {
        revealItems.forEach((item) => {
            item.classList.add(
                'pk-home-visible'
            );
        });

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Intersection Observer
    |--------------------------------------------------------------------------
    */

    if ('IntersectionObserver' in window) {
        const observer =
            new IntersectionObserver(
                (entries, obs) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) {
                            return;
                        }

                        entry.target.classList.add(
                            'pk-home-visible'
                        );

                        obs.unobserve(
                            entry.target
                        );
                    });
                },
                {
                    threshold: 0.08,
                    rootMargin:
                        '0px 0px -35px 0px',
                }
            );

        revealItems.forEach((item) => {
            observer.observe(item);
        });
    } else {
        /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        */

        revealItems.forEach((item) => {
            item.classList.add(
                'pk-home-visible'
            );
        });
    }
});