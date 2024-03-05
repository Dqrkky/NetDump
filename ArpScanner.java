import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.InetAddress;
import java.util.HashMap;

public class ArpScanner {

    public static void main(String[] args) {
        try {
            String osName = System.getProperty("os.name").toLowerCase();
            String arpCommand = "";
            if (osName.contains("windows")) {
                arpCommand = "arp -a";
            } else if (osName.contains("linux")) {
                arpCommand = "ip neigh show";
            } else {
                System.err.println("Unsupported operating system: " + osName);
                return;
            }
            Process process = Runtime.getRuntime().exec(arpCommand);
            BufferedReader reader = new BufferedReader(new InputStreamReader(process.getInputStream()));
            String line;
            while ((line = reader.readLine()) != null) {
                InetAddress inetAddress = InetAddress.getByName(line.split(" ")[0]);
                HashMap<String, Object> data = getDataDictionary(inetAddress);
                System.out.println("Data Dictionary: " + data);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
    public static HashMap<String, Object> getDataDictionary(InetAddress inetAddress) {
        HashMap<String, Object> data = new HashMap<>();
        try {
            String ipAddress = inetAddress.getHostAddress();
            data.put("ip_address", ipAddress);

            String hostname = inetAddress.getHostName();
            data.put("hostname", hostname);

            String canonicalHostname = inetAddress.getCanonicalHostName();
            data.put("canonical_hostname", canonicalHostname);

            byte[] addressBytes = inetAddress.getAddress();
            data.put("address_bytes", addressBytes);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return data;
    }
}
