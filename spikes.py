import pyshark

def capture_live_packets(network_interface=None):
    if network_interface != None:
        with pyshark.LiveCapture(interface=network_interface, tshark_path="D:\\Programs\\Other\\WiresharkPortable64\\App\\Wireshark\\tshark.exe") as capture:
            for raw_packet in capture.sniff_continuously():
                data = {
                    "captured_length": raw_packet.captured_length,
                    "length": raw_packet.length,
                    "sniff_time": raw_packet.sniff_time,
                    "number": raw_packet.number,
                    "highest_layer": raw_packet.highest_layer,
                    "transport_layer": raw_packet.transport_layer,
                    "layers": raw_packet.layers,
                    "frame_info": raw_packet.frame_info
                }
                yield data

def get_packet_details(packet):
    protocol = packet.transport_layer
    source_address = packet.ip.src
    destination_address = packet.ip.dst
    source_port = packet[protocol].srcport
    destination_port = packet[protocol].dstport
    return f"\Protocol type: {protocol}\nSource address: {source_address}\nSource port: {source_port}\nDestination address: {destination_address}\nDestination port: {destination_port}"

for packet in capture_live_packets(network_interface="Ethernet 2"):
    print(packet)