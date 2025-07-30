// import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

import Theme from './components/theme';

document.addEventListener('alpine:init', () => {
    Alpine.plugin(Theme)
})
 
Livewire.start()