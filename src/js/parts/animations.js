import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger.js'

gsap.registerPlugin(ScrollTrigger);


export const animateOrder = () => {
    if (window.innerWidth <= 768) return;

    const supportLines = gsap.utils.toArray(".order-item");
    const order = document.querySelector('.order');

    // const distanceFromTop = getCoords(order);

    // if (supportLines.length) {
    //     const list = document.querySelector('.order-items');
    //     const smallTimeline = gsap.timeline();
    //     let height = 0;

    //     supportLines.forEach((item, i) => {
    //         if (i != 0) {
    //             height += item.getBoundingClientRect().height;
    //             height += window.innerHeight * 0.6 - i * 67;

    //             const rect = item.getBoundingClientRect();
    //             const initialTop = rect.top; // Позиция до трансформаций (если transform не применялся)
    //             // height += rect.top + window.scrollY; // Текущая позиция с учётом скролла
    //         }
    //     });

    //     console.log(height);

    //     ScrollTrigger.create({
    //         trigger: '.order',
    //         start: "top 50px",
    //         end: `+=${height}`,
    //         scrub: 0.75,
    //         markers: true,
    //         invalidateOnRefresh: true,
    //         pin: true,
    //         // animation: smallTimeline,
    //         onUpdate: self => {
    //             let progress = self.progress

    //             let top = window.scrollY - distanceFromTop + 50
    //             console.log(top);

    //             list.scrollTop = top
    //         }
    //     })


    //     smallTimeline.to(supportLines, {
    //         // y: 0,
    //     })
    // }

    let top = document.querySelector('.header').getBoundingClientRect().height;
    top += 50

    supportLines.forEach((text, i) => {
        let tl = gsap.timeline({
            scrollTrigger: {
                trigger: order,
                start: () => "top -" + (window.innerHeight * i),
                end: () => "+=" + window.innerHeight,
                scrub: true,
                toggleActions: "play none reverse none",
                invalidateOnRefresh: true,
            }
        })
            .to(text, { y: 0 + i * 67 })
    });

    ScrollTrigger.create({
        trigger: "section.order",
        scrub: true,
        // markers: true,
        pin: true,
        start: () => `top ${top}`,
        end: () => "+=" + ((supportLines.length + 1) * window.innerHeight),
        invalidateOnRefresh: true,
    });

}



function getCoords(elem) {
    let box = elem.getBoundingClientRect();

    return box.top + window.pageYOffset;
}

