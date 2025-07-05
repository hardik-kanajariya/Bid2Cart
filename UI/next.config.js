/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: false,
  trailingSlash: true,
  swcMinify: true,
  images: {
    loader: 'custom',
    domains: ['127.0.0.1'],
  }
}

module.exports = nextConfig
