import Link from "next/link";
import {useRouter} from "next/router";
import React, {useEffect, useReducer, useState} from "react";

function Header() {
    // const [search, setSearch] = useState(false);
    const [sidebar, setSidebar] = useState(false);
    const router = useRouter();
    const currentRouter = router.pathname;
    /*---------Using reducer mange the active or inactive menu----------*/
    const initialState = {activeMenu: ""};
    const [state, dispatch] = useReducer(reducer, initialState);
    const [btn, setBtn] = useState('');
    const [darkMode, setDarkMode] = useState(false);
    const [logo, setLogo] = useState('')

    function reducer(state, action) {
        switch (action.type) {
            case "homeOne":
                return {activeMenu: "homeOne"};
            case "pages":
                return {activeMenu: "pages"};
            case "news":
                return {activeMenu: "news"};
            case "brows":
                return {activeMenu: "brows"};
            case "itwork":
                return {activeMenu: "itwork"};
            case "about":
                return {activeMenu: "about"};
            case "contact":
                return {activeMenu: "contact"};
            default:
                return {activeMenu: ""};
        }
    }

    /*-----------mobile menu events-----------*/
    const handleSidbarMenu = () => {
        if (sidebar === false || sidebar === 0) {
            setSidebar(1);
        } else {
            setSidebar(false);
        }
    };
    /*-----------Sticky Menu Area-----------*/
    useEffect(() => {
        setDarkMode(isDarkMode())
        window.addEventListener("scroll", isSticky);
        setBtn(sessionStorage.getItem('token'))
        return () => {
            window.removeEventListener("scroll", isSticky);
        };
    }, [darkMode]);

    /*----------- Method that will fix header after a specific scrollable -----------*/
    const isSticky = (e) => {
        const header = document.querySelector(".header-area");
        const scrollTop = window.scrollY;
        scrollTop >= 20
            ? header.classList.add("sticky")
            : header.classList
                ? header.classList.remove("sticky")
                : header.classList.add("sticky");
    };

    function isDarkMode() {
        let mediaQueryObj = window.matchMedia('(prefers-color-scheme: dark)');
        let isDarkMode = mediaQueryObj.matches;
        // console.log("Dark mode status: ", isDarkMode)
        return isDarkMode;
    }


    return (
        <>
            <header className="header-area style">
                <div className="header-logo">
                    <Link href="/">
                        <a>
                            <img alt="image" src={darkMode ? "/assets/images/logo_dark.png" : "/assets/images/logo.png"}
                                 width="30" height="50"/>
                        </a>
                    </Link>
                </div>
                <div className={sidebar === 1 ? "main-menu show-menu" : "main-menu"}>
                    <div className="mobile-logo-area d-lg-none d-flex justify-content-between align-items-center">
                        <div className="mobile-logo-wrap ">
                            <Link href="/">
                                <a>
                                    <img
                                        alt="image"
                                        src={darkMode ? "/assets/images/logo_dark.png" : "/assets/images/logo.png"}
                                        width="150" height="50"
                                    />
                                </a>
                            </Link>
                        </div>
                        <div className="menu-close-btn" onClick={handleSidbarMenu}>
                            <i className="bi bi-x-lg"/>
                        </div>
                    </div>
                    <ul className="menu-list">
                        <li onClick={() => dispatch({type: "homeOne"})}>
                            <Link href="/">
                                <a className={currentRouter === "/" ? "active" : "desable"}>
                                    Home
                                </a>
                            </Link>
                        </li>
                        <li>
                            <Link href="/live-auction">
                                <a
                                    className={
                                        currentRouter === "/live-auction" ? "active" : "desable"
                                    }
                                >
                                    Browse Products
                                </a>
                            </Link>
                        </li>
                        <li>
                            <Link href="/about">
                                <a className={currentRouter === "/about" ? "active" : "desable"}>
                                    About Us
                                </a>
                            </Link>
                        </li>
                        <li>
                            <Link href="/how-works">
                                <a
                                    className={
                                        currentRouter === "/how-works" ? "active" : "desable"
                                    }
                                >
                                    How It Works
                                </a>
                            </Link>
                        </li>

                        <li>
                            <Link href="/contact">
                                <a
                                    className={
                                        currentRouter === "/contact" ? "active" : "desable"
                                    }
                                >
                                    Contact
                                </a>
                            </Link>
                        </li>
                        <li>
                            <Link href="/faq">
                                <a
                                    className={
                                        currentRouter === "/faq" ? "active" : "desable"
                                    }
                                >
                                    FAQs
                                </a>
                            </Link>
                        </li>
                    </ul>
                    {/* Mobile My Account Button */}
                    <Link href={btn ? "/dashboard" : "/login"}>
                        <div className="d-lg-none d-block">
                            <div className="hotline two">
                                <div className="hotline-info">
                                    <h6 className="border border-dark p-2">
                                        My Account
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
                <div className="nav-right d-flex align-items-center">
                    <div className="hotline d-xxl-flex d-none">
                        <div className="hotline-icon">
                            <img alt="image" src="/assets/images/icons/header-phone.svg"/>
                        </div>
                        <div className="hotline-info">
                            <span>Click To Call</span>
                            <h6>
                                <a href="tel:347-274-8816">+347-274-8816</a>
                            </h6>
                        </div>
                    </div>
                    <Link href={btn ? "/dashboard" : "/login"}>
                        <div className="eg-btn btn--primary header-btn">
                            My Account
                        </div>
                    </Link>
                    <div className="mobile-menu-btn d-lg-none d-block" onClick={handleSidbarMenu}>
                        <i className="bx bx-menu"/>
                    </div>
                </div>
            </header>
        </>
    );
}

export default Header;
