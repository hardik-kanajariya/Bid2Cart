import Head from "next/head";
import React from "react";
import CounterUp from "../common/CounterUp";
import Footer from "../common/Footer";
import Header from "../common/Header";

function Layout({children}) {
    return (
        <>
            <Head>
                <title>Bid2Cart Proxy Bidding</title>
                <meta name="description" content="Bid2Cart Auction"/>
                <link rel="icon" href="/assets/images/logo.png"/>
            </Head>
            {/* <Topbar /> */}
            <Header logo="header-logo"/>
            {children}
            <CounterUp/>
            <Footer/>
        </>
    );
}

export default Layout;
