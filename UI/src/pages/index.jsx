import Head from "next/head";
import { useEffect, useState, useCallback } from "react";
import PropTypes from "prop-types";

// Component imports
import Category from "../components/category/Category";
import CounterUp from "../components/common/CounterUp";
import Footer from "../components/common/Footer";
import Header from "../components/common/Header";
import Preloader from "../components/common/Preloader";
import LiveAuction from "../components/LiveAuction/LiveAuction";
import Topbar from "../components/common/Topbar";
import Banner from "../components/Banner/Banner";
import ErrorBoundary from "../components/common/ErrorBoundary";

// Constants
const PRELOADER_DELAY = 1000; // milliseconds
const PAGE_TITLE = "Bid2Cart - Bid and Auction website";
const PAGE_DESCRIPTION = "Bid2Cart Auction House - Your premier destination for online auctions";
const FAVICON_PATH = "/assets/images/logo.png";

/**
 * Home Page Component
 * Main landing page for the Bid2Cart auction website
 */
function Home() {
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);

    /**
     * Handle component initialization and preloader
     */
    const initializePage = useCallback(() => {
        try {
            // Simulate loading time for better UX
            const timer = setTimeout(() => {
                setIsLoading(false);
            }, PRELOADER_DELAY);

            // Cleanup function
            return () => clearTimeout(timer);
        } catch (err) {
            console.error("Error initializing page:", err);
            setError("Failed to initialize page");
            setIsLoading(false);
        }
    }, []);

    useEffect(() => {
        const cleanup = initializePage();
        return cleanup;
    }, [initializePage]);

    /**
     * Error fallback component
     */
    const ErrorFallback = ({ error, resetError }) => (
        <div className="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
            <div className="text-center">
                <h2 className="text-danger mb-3">Something went wrong</h2>
                <p className="text-muted mb-4">{error}</p>
                <button
                    className="btn btn-primary"
                    onClick={resetError}
                    aria-label="Retry loading page"
                >
                    Try Again
                </button>
            </div>
        </div>
    );

    /**
     * Reset error state
     */
    const resetError = useCallback(() => {
        setError(null);
        setIsLoading(true);
        initializePage();
    }, [initializePage]);

    /**
     * Render preloader
     */
    const renderPreloader = () => (
        <Preloader
            classText="preloader"
            ariaLabel="Loading page content"
        />
    );

    /**
     * Render main content
     */
    const renderMainContent = () => (
        <>
            <Head>
                <title>{PAGE_TITLE}</title>
                <meta name="description" content={PAGE_DESCRIPTION} />
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <meta name="robots" content="index, follow" />
                <link rel="icon" href={FAVICON_PATH} />
                <link rel="canonical" href="https://bid2cart.com" />
            </Head>
            <Topbar />
            <header role="banner">
                <Header logo="header-logo" />
            </header>

            <main role="main">
                {/* Live Auction Section */}
                <section className="live-auction-section" aria-labelledby="live-auction-title">
                    <ErrorBoundary fallback={<div className="alert alert-warning">Unable to load live auctions</div>}>
                        <LiveAuction />
                    </ErrorBoundary>
                </section>

                {/* Categories Section */}
                <section className="categories-section py-5" aria-labelledby="categories-title">
                    <div className="container">
                        <div className="row justify-content-center">
                            <div className="col-12 col-md-10 col-lg-8 col-xl-6">
                                <div className="section-title text-center mb-4">
                                    <h2 id="categories-title" className="h2 fw-bold">
                                        Categories
                                    </h2>
                                </div>
                            </div>
                        </div>

                        <div className="row d-flex justify-content-center mt-1">
                            <ErrorBoundary fallback={<div className="alert alert-warning">Unable to load categories</div>}>
                                <Category />
                            </ErrorBoundary>
                        </div>
                    </div>
                </section>

                {/* Counter Section */}
                <section className="counter-section py-5" aria-labelledby="stats-title">
                    <ErrorBoundary fallback={<div className="alert alert-warning">Unable to load statistics</div>}>
                        <CounterUp />
                    </ErrorBoundary>
                </section>
            </main>

            <Footer />
        </>
    );

    // Handle error state
    if (error) {
        return <ErrorFallback error={error} resetError={resetError} />;
    }

    // Main render
    return (
        <ErrorBoundary fallback={<ErrorFallback error="Application error" resetError={resetError} />}>
            {isLoading ? renderPreloader() : renderMainContent()}
        </ErrorBoundary>
    );
}

// PropTypes (if needed for props in the future)
Home.propTypes = {};

// Default props (if needed for props in the future)
Home.defaultProps = {};

export default Home;