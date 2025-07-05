import Head from "next/head";
import {useEffect, useState} from "react";
import Category from "../components/category/Category";
import CounterUp from "../components/common/CounterUp";
import Footer from "../components/common/Footer";
import Header from "../components/common/Header";
import Preloader from "../components/common/Preloader";
import LiveAuction from "../components/LiveAuction/LiveAuction";

function Home() {
    const [isLoaded, setIsLoaded] = useState(true)
    useEffect(() => {
        setIsLoaded(false)
    }, [])
    return (
        <>
            {isLoaded ? (
                <Preloader classText="preloader"/>
            ) : (
                <>
                    <Head>
                        <title>Bid2Cart - Bid and Auction website</title>
                        <meta name="description" content="Bid2Cart Auction House"/>
                        <link rel="icon" href="/assets/images/logo.png"/>
                    </Head>
                    {/* <Topbar /> */}
                    <Header logo={"header-logo"}/>
                    {/*<Banner />*/}
                    <LiveAuction/>
                    <div className="row d-flex justify-content-center mt-1">
                        <div className="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                            <div className="section-title">
                                <h2>Categories</h2>
                            </div>
                        </div>
                    </div>
                    <div className="mx-4 parent mb-1">
                        <Category/>
                    </div>
                    <CounterUp/>
                    <Footer/>
                </>
            )}
        </>
    );
}

export default Home;
