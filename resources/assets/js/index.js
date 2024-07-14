import { gsap } from 'gsap';
import { library, dom } from '@fortawesome/fontawesome-svg-core';
import { faEdit, faEnvelope, faHeart, faTrash } from '@fortawesome/free-solid-svg-icons';
import { faGithub, faLinkedin, faTwitter } from '@fortawesome/free-brands-svg-icons';
import SplitText from './split-text';

window.SplitText = SplitText;
window.gsap = gsap;

library.add(
    faEdit,
    faEnvelope,
    faHeart,
    faGithub,
    faLinkedin,
    faTrash,
    faTwitter
);

dom.watch();
