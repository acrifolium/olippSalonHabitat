/**
 * Utility functions to parse CSV data directly in the browser
 */

var csvParser = {
    /**
     * Parse CSV string into array of objects
     * @param {string} csvString - Raw CSV string
     * @param {string} delimiter - CSV delimiter (default: ",")
     * @return {Array} Array of parsed objects
     */
    parseExposants: function(csvString, delimiter) {
        delimiter = delimiter || ',';
        
        // Split into lines
        const lines = csvString.split('\n');
        const result = [];
        
        // Process each line
        lines.forEach(line => {
            if (!line.trim()) return; // Skip empty lines
            
            // Split the line by delimiter but respect quoted values
            const values = this.splitCSVLine(line, delimiter);
            
            // Create object structure matching the old PHP structure
            const node = {};
            node.name = values[0] || '';
            node.description = values[1] || '';
            
            const address = {};
            address.contact = values[2] || '';
            address.firstline = values[3] || '';
            address.postalCode = values[4] || '';
            address.city = values[5] || '';
            node.address = address;
            
            node.telephone = values[6] || '';
            node.portable = values[7] || '';
            node.mail = values[8] || '';
            node.webSite = values[9] || '';
            
            result.push(node);
        });
        
        return result;
    },
    
    /**
     * Parse CSV string into array of annonceur objects
     * @param {string} csvString - Raw CSV string
     * @param {string} delimiter - CSV delimiter (default: ",")
     * @return {Array} Array of parsed objects
     */
    parseAnnonceurs: function(csvString, delimiter) {
        delimiter = delimiter || ',';
        
        // Split into lines
        const lines = csvString.split('\n');
        const result = [];
        
        // Process each line
        lines.forEach(line => {
            if (!line.trim()) return; // Skip empty lines
            
            // Split the line by delimiter but respect quoted values
            const values = this.splitCSVLine(line, delimiter);
            
            // Create object structure matching the old PHP structure
            const node = {};
            node.name = values[0] || '';
            node.description = values[1] || '';
            
            const address = {};
            address.postalCode = values[2] || '';
            address.city = values[3] || '';
            node.address = address;
            
            node.telephone = values[4] || '';
            
            result.push(node);
        });
        
        return result;
    },
    
    /**
     * Split CSV line respecting quoted fields
     * @param {string} line - CSV line to split
     * @param {string} delimiter - CSV delimiter
     * @return {Array} Array of field values
     */
    splitCSVLine: function(line, delimiter) {
        const result = [];
        let currentValue = '';
        let insideQuotes = false;
        
        for (let i = 0; i < line.length; i++) {
            const char = line[i];
            
            if (char === '"') {
                insideQuotes = !insideQuotes;
            } else if (char === delimiter && !insideQuotes) {
                result.push(currentValue);
                currentValue = '';
            } else {
                currentValue += char;
            }
        }
        
        // Push the last value
        result.push(currentValue);
        
        return result;
    }
};