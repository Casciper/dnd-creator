
function getCommandBar() {
    let container = document.querySelector('.command-bar');
    let newContainer;

    setTimeout(() => {
        const oldContainer = document.querySelector('.mobile-commandbar');
        if (oldContainer) {
            oldContainer.remove();
        }
    }, 300);

    const createMobileCommandBar = () => {
        newContainer = document.createElement('div');
        newContainer.classList.add('mobile-commandbar', 'show');

        const commandBarLayout = document.querySelector('.commandbar-layout');
        if (commandBarLayout) {
            const clonedElement = commandBarLayout.cloneNode(true);
            newContainer.append(clonedElement);
        }

        const postForm = document.querySelector('#post-form');
        if (postForm) {
            const postFormWidth = postForm.offsetWidth;
            newContainer.style.width = `${postFormWidth}px`;
        }

        function setPosition(){
            if (newContainer) {
                const adminBackground = document.querySelector('.admin-background');
                if (adminBackground) {
                    let postFormRect = postForm.getBoundingClientRect();
                    newContainer.style.left = postFormRect.left + 'px';
                }
            }
        }

        window.addEventListener('resize', function() {
            setPosition();
        });
        setPosition();

        document.body.appendChild(newContainer);

            newContainer.style.opacity = '0';
            newContainer.style.transition = 'opacity 0.5s, transform 0.5s';
            newContainer.style.position = 'fixed';
            newContainer.style.top = '-400px';
            newContainer.style.transform = 'translateY(-400px)';
            setTimeout(() => {
                newContainer.style.top = '0px';
                newContainer.style.opacity = '1';
                newContainer.style.transform = 'translateY(0px)';
            }, 300);
    };

    const removeMobileCommandBar = () => {
        if (newContainer) {
            newContainer.style.opacity = '0';
            newContainer.style.transform = 'translateY(-100px)';

            setTimeout(() => {
                newContainer.remove();
                newContainer = null;
            }, 500);
        }
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                if (!newContainer) {
                    createMobileCommandBar();
                }
            } else {
                removeMobileCommandBar();
            }
        });
    });

    observer.observe(container);
}
document.addEventListener('turbo:load', () => {
    getCommandBar();
});

getCommandBar();
