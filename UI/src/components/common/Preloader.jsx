import Head from "next/head";
import React from "react";

function Preloader() {
    return (<>
            <Head>
                <title>Loading....</title>
            </Head>
            <div className="preloader style-1">
                <div className="loader">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </>);
}

export default Preloader;
