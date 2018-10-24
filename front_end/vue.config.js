module.exports = {
    devServer: {
        // proxy: 'http://localhost:3010',
        proxy: {
            '/api/gateway': {
                target: 'http://localhost:3010',
                ws: true,
                changeOrigin: true
              }
        }
        
    }
};