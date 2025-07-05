import React, {useEffect, useState} from "react";
import Breadcrumb from "../components/common/Breadcrumb";
import ContentTab from "../components/dashboard/ContentTab";
import WatchList from "../components/dashboard/WatchList";
import ProfileTab from "../components/dashboard/ProfileTab";
import MyBids from "../components/dashboard/MyBids";
import Layout from "../components/layout/Layout";
import Preloader from "../components/common/Preloader";
import Router from "next/router";
import DashboardMenu from "../components/dashboard/DashboardMenu";
import RequestPickup from "../components/dashboard/RequestPickup";
import Notification from "../components/dashboard/Notification";

function DashboardPage() {
    const [isLoaded, setIsLoaded] = useState(true)
    useEffect(() => {
        if (!sessionStorage.getItem('token')) {
            Router.push('/login')
        }
        setIsLoaded(false)
    }, [isLoaded])
    return (
        <>
            {isLoaded ? (
                <Preloader classText="preloader"/>
            ) : (<Layout>
                <Breadcrumb pageTitle="Dashboard" pageName="Dashboard"/>
                <div className="dashboard-section pt-120 pb-120">
                    <img alt="images" src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-top"/>
                    <img alt="images" src="/assets/images/bg/section-bg.png" className="img-fluid section-bg-bottom"/>
                    <div className="container">
                        <div className="row g-4">
                            <DashboardMenu/>
                            <div className="col-lg-9">
                                <div className="tab-content" id="v-pills-tabContent">
                                    <ContentTab/>
                                    <ProfileTab/>
                                    <WatchList/>
                                    <MyBids/>
                                    <Notification/>
                                    <RequestPickup/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Layout>)}
        </>

    );
}

export default DashboardPage;
