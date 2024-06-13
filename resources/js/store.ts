import {create, UseBoundStore} from "zustand";

interface languageState {
    kz: boolean,
    invert:() => void,
}

function setKz(): boolean {
    const language = localStorage.getItem('language');
    return language === 'kz' || language === null;
}

export const useStore = create<languageState>((set) => ({
    kz: setKz(),
    invert: () => {
        if (localStorage.getItem('language') === 'kz') {
            localStorage.setItem('language', 'ru');
        } else {
            localStorage.setItem('language', 'kz');
        }

        set((state) => ({ kz: !state.kz }));
    },
}));
